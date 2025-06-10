<?php
// app/Http/Controllers/Admin/AnalyticsController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PoorFamily;
use App\Models\Village;
use App\Models\User;
use App\Models\PovertyCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AnalyticsController extends Controller
{
    public function dashboardStats()
    {
        $stats = [
            'total_families' => PoorFamily::count(),
            'verified_families' => PoorFamily::verified()->count(),
            'pending_families' => PoorFamily::submitted()->count(),
            'rejected_families' => PoorFamily::where('status_verifikasi', 'rejected')->count(),
            'total_petugas' => User::petugasLapangan()->active()->count(),
            'inactive_petugas' => User::petugasLapangan()->where('is_active', false)->count(),
        ];

        // Monthly trends
        $monthlyTrends = PoorFamily::selectRaw('YEAR(created_at) as year, MONTH(created_at) as month, COUNT(*) as total')
                                  ->where('created_at', '>=', Carbon::now()->subMonths(12))
                                  ->groupBy('year', 'month')
                                  ->orderBy('year', 'asc')
                                  ->orderBy('month', 'asc')
                                  ->get();

        return response()->json([
            'stats' => $stats,
            'monthly_trends' => $monthlyTrends
        ]);
    }

    public function povertyTrends(Request $request)
    {
        $period = $request->get('period', 'month');
        
        $query = PoorFamily::verified();
        
        switch ($period) {
            case 'week':
                $data = $query->selectRaw('DATE(created_at) as date, COUNT(*) as total')
                             ->where('created_at', '>=', Carbon::now()->subWeeks(4))
                             ->groupBy('date')
                             ->orderBy('date')
                             ->get();
                break;
            case 'month':
                $data = $query->selectRaw('YEAR(created_at) as year, MONTH(created_at) as month, COUNT(*) as total')
                             ->where('created_at', '>=', Carbon::now()->subMonths(12))
                             ->groupBy('year', 'month')
                             ->orderBy('year', 'asc')
                             ->orderBy('month', 'asc')
                             ->get();
                break;
            case 'year':
                $data = $query->selectRaw('YEAR(created_at) as year, COUNT(*) as total')
                             ->where('created_at', '>=', Carbon::now()->subYears(5))
                             ->groupBy('year')
                             ->orderBy('year')
                             ->get();
                break;
        }

        return response()->json($data);
    }

    public function villageComparison()
    {
        $villageStats = Village::with(['poorFamilies' => function($query) {
            $query->verified();
        }])->get()->map(function($village) {
            $families = $village->poorFamilies;
            $totalFamilies = $families->count();
            
            if ($totalFamilies === 0) {
                return null;
            }
            
            $povertyLevels = $families->groupBy(function($family) {
                return $family->poverty_level;
            })->map->count();
            
            return [
                'village_name' => $village->name,
                'total_families' => $totalFamilies,
                'avg_poverty_score' => round($families->avg('poverty_score'), 2),
                'poverty_levels' => $povertyLevels,
                'economic_data' => $families->groupBy('sumber_penghasilan')->map->count(),
                'housing_data' => $families->groupBy('jenis_bangunan')->map->count(),
            ];
        })->filter()->values();

        return response()->json($villageStats);
    }

    public function customReport(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'villages' => 'array',
            'categories' => 'array',
            'poverty_levels' => 'array',
        ]);

        $query = PoorFamily::with(['neighborhood.village', 'categories'])
                           ->whereBetween('created_at', [$request->start_date, $request->end_date]);

        if ($request->filled('villages')) {
            $query->whereHas('neighborhood', function($q) use ($request) {
                $q->whereIn('village_id', $request->villages);
            });
        }

        if ($request->filled('poverty_levels')) {
            $query->whereIn('poverty_level', $request->poverty_levels);
        }

        $families = $query->get();

        // Generate comprehensive report data
        $reportData = [
            'summary' => [
                'total_families' => $families->count(),
                'avg_poverty_score' => round($families->avg('poverty_score'), 2),
                'poverty_distribution' => $families->groupBy('poverty_level')->map->count(),
            ],
            'economic_analysis' => [
                'income_sources' => $families->groupBy('sumber_penghasilan')->map->count(),
                'avg_income' => round($families->where('penghasilan_bulanan', '>', 0)->avg('penghasilan_bulanan'), 0),
                'ownership_status' => $families->groupBy('status_kepemilikan')->map->count(),
            ],
            'housing_analysis' => [
                'building_types' => $families->groupBy('jenis_bangunan')->map->count(),
                'floor_types' => $families->groupBy('lantai_rumah')->map->count(),
                'water_sources' => $families->groupBy('sumber_air')->map->count(),
                'electricity_sources' => $families->groupBy('sumber_listrik')->map->count(),
            ],
            'social_analysis' => [
                'education_access' => $families->groupBy('akses_sekolah')->map->count(),
                'health_access' => $families->groupBy('akses_kesehatan')->map->count(),
                'children_not_in_school' => $families->where('anak_tidak_sekolah', true)->count(),
                'disabled_elderly' => $families->where('ada_difabel_lansia', true)->count(),
                'chronic_illness' => $families->where('ada_sakit_menahun', true)->count(),
            ],
            'government_aid' => [
                'pkh_recipients' => $families->filter(function($family) {
                    return in_array('pkh', $family->bantuan_pemerintah ?? []);
                })->count(),
                'bpnt_recipients' => $families->filter(function($family) {
                    return in_array('bpnt', $family->bantuan_pemerintah ?? []);
                })->count(),
                'blt_recipients' => $families->filter(function($family) {
                    return in_array('blt', $family->bantuan_pemerintah ?? []);
                })->count(),
            ],
        ];

        return response()->json($reportData);
    }

    public function categoryAnalysis(Request $request)
    {
        $category = $request->get('category', 'ekonomi');
        
        $categoryData = PovertyCategory::where('kategori', $category)
                                      ->with('poorFamily.neighborhood.village')
                                      ->get();

        $analysis = [
            'score_distribution' => $categoryData->groupBy('skor')->map->count(),
            'avg_score' => round($categoryData->avg('skor'), 2),
            'village_breakdown' => $categoryData->groupBy('poorFamily.neighborhood.village.name')->map->count(),
            'recommendations' => $this->generateRecommendations($category, $categoryData),
        ];

        return response()->json($analysis);
    }

    private function generateRecommendations($category, $categoryData)
    {
        $avgScore = $categoryData->avg('skor');
        $recommendations = [];

        switch ($category) {
            case 'ekonomi':
                if ($avgScore >= 4) {
                    $recommendations[] = 'Perlu program pelatihan keterampilan dan modal usaha';
                    $recommendations[] = 'Fasilitasi akses ke lembaga keuangan mikro';
                }
                break;
            case 'kesehatan':
                if ($avgScore >= 4) {
                    $recommendations[] = 'Tingkatkan jumlah fasilitas kesehatan';
                    $recommendations[] = 'Program kesehatan preventif dan edukasi';
                }
                break;
            case 'pendidikan':
                if ($avgScore >= 4) {
                    $recommendations[] = 'Program beasiswa dan bantuan pendidikan';
                    $recommendations[] = 'Pembangunan sekolah di daerah terpencil';
                }
                break;
            case 'sanitasi':
                if ($avgScore >= 4) {
                    $recommendations[] = 'Program perbaikan sanitasi dan air bersih';
                    $recommendations[] = 'Edukasi kebersihan dan kesehatan lingkungan';
                }
                break;
            case 'infrastruktur':
                if ($avgScore >= 4) {
                    $recommendations[] = 'Pembangunan jalan dan jembatan';
                    $recommendations[] = 'Peningkatan akses listrik dan telekomunikasi';
                }
                break;
        }

        return $recommendations;
    }
}
