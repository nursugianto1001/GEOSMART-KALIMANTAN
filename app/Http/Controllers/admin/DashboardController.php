<?php
// app/Http/Controllers/Admin/DashboardController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PoorFamily;
use App\Models\User;
use App\Models\Village;
use App\Models\PovertyCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_families' => PoorFamily::count(),
            'verified_families' => PoorFamily::verified()->count(),
            'pending_families' => PoorFamily::submitted()->count(),
            'total_petugas' => User::petugasLapangan()->active()->count(),
        ];

        $recentSurveys = PoorFamily::with(['surveyor', 'neighborhood.village'])
            ->latest()
            ->take(10)
            ->get();

        $surveysByStatus = PoorFamily::select('status_verifikasi', DB::raw('count(*) as total'))
            ->groupBy('status_verifikasi')
            ->get();

        $surveysByVillage = PoorFamily::join('neighborhoods', 'poor_families.neighborhood_id', '=', 'neighborhoods.id')
            ->join('villages', 'neighborhoods.village_id', '=', 'villages.id')
            ->select('villages.name', DB::raw('count(*) as total'))
            ->groupBy('villages.name')
            ->get()
            ->pluck('total', 'name');

        return view('admin.dashboard', compact(
            'stats',
            'recentSurveys',
            'surveysByStatus',
            'surveysByVillage'
        ));
    }

    public function analytics()
    {
        $familiesByEconomicStatus = PoorFamily::select('sumber_penghasilan', DB::raw('count(*) as total'))
            ->groupBy('sumber_penghasilan')
            ->get();

        $familiesByHouseCondition = PoorFamily::select('jenis_bangunan', DB::raw('count(*) as total'))
            ->groupBy('jenis_bangunan')
            ->get();

        $familiesByEducationAccess = PoorFamily::select('akses_sekolah', DB::raw('count(*) as total'))
            ->groupBy('akses_sekolah')
            ->get();

        $familiesByHealthAccess = PoorFamily::select('akses_kesehatan', DB::raw('count(*) as total'))
            ->groupBy('akses_kesehatan')
            ->get();

        // Poverty level distribution
        $povertyLevels = PoorFamily::verified()->get()->groupBy(function ($family) {
            return $family->poverty_level;
        })->map->count();

        return view('admin.analytics', compact(
            'familiesByEconomicStatus',
            'familiesByHouseCondition',
            'familiesByEducationAccess',
            'familiesByHealthAccess',
            'povertyLevels'
        ));
    }

    public function surveys(Request $request)
    {
        $query = PoorFamily::with(['neighborhood.village', 'surveyor']);

        // ✅ PERBAIKAN: Status filter
        if ($request->filled('status')) {
            $query->where('status_verifikasi', $request->status);
        } else {
            // Default: hanya yang submitted
            $query->where('status_verifikasi', 'submitted');
        }

        // ✅ PERBAIKAN: Surveyor filter
        if ($request->filled('surveyor')) {
            $query->where('surveyor_id', $request->surveyor);
        }

        // ✅ PERBAIKAN: Date range filter
        if ($request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }

        if ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        // ✅ PERBAIKAN: Search by nama kepala keluarga
        if ($request->filled('search')) {
            $query->where('nama_kepala_keluarga', 'like', '%' . $request->search . '%');
        }

        // ✅ PERBAIKAN: Poverty level filter
        if ($request->filled('poverty_level')) {
            $query->whereIn('poverty_level', $request->poverty_level);
        }

        $surveys = $query->latest()->paginate(15)->withQueryString();

        return view('admin.surveys.index', compact('surveys'));
    }

    public function showSurvey(PoorFamily $survey)
    {
        $survey->load(['neighborhood.village.district', 'surveyor', 'verifier', 'categories']);
        return view('admin.surveys.show', compact('survey'));
    }

    public function verifySurvey(Request $request, PoorFamily $survey)
    {
        $survey->update([
            'status_verifikasi' => 'verified',
            'verified_by' => auth()->id(),
            'verified_at' => now(),
            'rejection_reason' => null,
        ]);

        return redirect()->back()->with('success', 'Survei berhasil diverifikasi');
    }

    public function rejectSurvey(Request $request, PoorFamily $survey)
    {
        $request->validate([
            'rejection_reason' => 'required|string|max:500'
        ]);

        $survey->update([
            'status_verifikasi' => 'rejected',
            'verified_by' => auth()->id(),
            'verified_at' => now(),
            'rejection_reason' => $request->rejection_reason,
        ]);

        return redirect()->back()->with('success', 'Survei berhasil ditolak');
    }

    public function bulkVerify(Request $request)
    {
        $surveyIds = $request->input('survey_ids', []);

        PoorFamily::whereIn('id', $surveyIds)
            ->where('status_verifikasi', 'submitted')
            ->update([
                'status_verifikasi' => 'verified',
                'verified_by' => auth()->id(),
                'verified_at' => now()
            ]);

        return redirect()->back()->with('success', count($surveyIds) . ' survei berhasil diverifikasi');
    }

    public function bulkReject(Request $request)
    {
        $request->validate([
            'survey_ids' => 'required|array',
            'rejection_reason' => 'required|string|max:500'
        ]);

        PoorFamily::whereIn('id', $request->survey_ids)
            ->where('status_verifikasi', 'submitted')
            ->update([
                'status_verifikasi' => 'rejected',
                'verified_by' => auth()->id(),
                'verified_at' => now(),
                'rejection_reason' => $request->rejection_reason
            ]);

        return redirect()->back()->with('success', count($request->survey_ids) . ' survei berhasil ditolak');
    }

    public function detailedStats()
    {
        $totalFamilies = PoorFamily::verified()->count();

        $stats = [
            'pdam_percentage' => $totalFamilies > 0 ? round((PoorFamily::verified()->where('sumber_air', 'pdam')->count() / $totalFamilies) * 100, 1) : 0,
            'pln_percentage' => $totalFamilies > 0 ? round((PoorFamily::verified()->where('sumber_listrik', 'pln')->count() / $totalFamilies) * 100, 1) : 0,
            'keramik_percentage' => $totalFamilies > 0 ? round((PoorFamily::verified()->where('lantai_rumah', 'keramik')->count() / $totalFamilies) * 100, 1) : 0,
            'tidak_sekolah_percentage' => $totalFamilies > 0 ? round((PoorFamily::verified()->where('anak_tidak_sekolah', true)->count() / $totalFamilies) * 100, 1) : 0,
            'difabel_percentage' => $totalFamilies > 0 ? round((PoorFamily::verified()->where('ada_difabel_lansia', true)->count() / $totalFamilies) * 100, 1) : 0,
            'sakit_percentage' => $totalFamilies > 0 ? round((PoorFamily::verified()->where('ada_sakit_menahun', true)->count() / $totalFamilies) * 100, 1) : 0,
            'pkh_percentage' => $totalFamilies > 0 ? round((PoorFamily::verified()->whereJsonContains('bantuan_pemerintah', 'pkh')->count() / $totalFamilies) * 100, 1) : 0,
            'bpnt_percentage' => $totalFamilies > 0 ? round((PoorFamily::verified()->whereJsonContains('bantuan_pemerintah', 'bpnt')->count() / $totalFamilies) * 100, 1) : 0,
            'blt_percentage' => $totalFamilies > 0 ? round((PoorFamily::verified()->whereJsonContains('bantuan_pemerintah', 'blt')->count() / $totalFamilies) * 100, 1) : 0,
        ];

        return response()->json($stats);
    }

    public function choroplethData()
    {
        $villageData = Village::with(['poorFamilies' => function ($query) {
            $query->verified();
        }])->get()->map(function ($village) {
            $families = $village->poorFamilies;
            $totalFamilies = $families->count();

            if ($totalFamilies === 0) {
                return [
                    'village_id' => $village->id,
                    'village_name' => $village->name,
                    'total_families' => 0,
                    'poverty_density' => 0,
                    'avg_poverty_score' => 0,
                    'color_intensity' => 0
                ];
            }

            $avgScore = $families->avg('poverty_score');
            $povertyDensity = ($totalFamilies / 1000) * 100;
            $colorIntensity = min($avgScore / 25, 1);

            return [
                'village_id' => $village->id,
                'village_name' => $village->name,
                'total_families' => $totalFamilies,
                'poverty_density' => round($povertyDensity, 2),
                'avg_poverty_score' => round($avgScore, 2),
                'color_intensity' => round($colorIntensity, 2)
            ];
        });

        return response()->json($villageData);
    }

    public function filteredData(Request $request)
    {
        $filters = $request->all();

        $query = PoorFamily::verified();

        // Apply filters
        if (isset($filters['period']) && $filters['period'] !== 'all') {
            switch ($filters['period']) {
                case 'month':
                    $query->where('created_at', '>=', Carbon::now()->startOfMonth());
                    break;
                case 'quarter':
                    $query->where('created_at', '>=', Carbon::now()->subMonths(3));
                    break;
                case 'year':
                    $query->where('created_at', '>=', Carbon::now()->startOfYear());
                    break;
            }
        }

        if (isset($filters['village']) && $filters['village']) {
            $query->whereHas('neighborhood', function ($q) use ($filters) {
                $q->where('village_id', $filters['village']);
            });
        }

        $families = $query->get();

        // Generate filtered data
        $economicData = $families->groupBy('sumber_penghasilan')->map->count();
        $houseData = $families->groupBy('jenis_bangunan')->map->count();
        $educationData = $families->groupBy('akses_sekolah')->map->count();
        $healthData = $families->groupBy('akses_kesehatan')->map->count();

        return response()->json([
            'economic' => [
                'labels' => $economicData->keys()->toArray(),
                'data' => $economicData->values()->toArray()
            ],
            'house' => [
                'labels' => $houseData->keys()->toArray(),
                'data' => $houseData->values()->toArray()
            ],
            'education' => [
                'labels' => $educationData->keys()->toArray(),
                'data' => $educationData->values()->toArray()
            ],
            'health' => [
                'labels' => $healthData->keys()->toArray(),
                'data' => $healthData->values()->toArray()
            ],
            'detailed_stats' => $this->calculateDetailedStats($families)
        ]);
    }

    private function calculateDetailedStats($families)
    {
        $total = $families->count();

        if ($total === 0) {
            return [];
        }

        return [
            'pdam_percentage' => round(($families->where('sumber_air', 'pdam')->count() / $total) * 100, 1),
            'pln_percentage' => round(($families->where('sumber_listrik', 'pln')->count() / $total) * 100, 1),
            'keramik_percentage' => round(($families->where('lantai_rumah', 'keramik')->count() / $total) * 100, 1),
            'tidak_sekolah_percentage' => round(($families->where('anak_tidak_sekolah', true)->count() / $total) * 100, 1),
            'difabel_percentage' => round(($families->where('ada_difabel_lansia', true)->count() / $total) * 100, 1),
            'sakit_percentage' => round(($families->where('ada_sakit_menahun', true)->count() / $total) * 100, 1),
        ];
    }
}
