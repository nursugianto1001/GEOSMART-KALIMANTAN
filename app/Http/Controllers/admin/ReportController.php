<?php
// app/Http/Controllers/Admin/ReportController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PoorFamily;
use App\Models\Village;
use App\Models\User;
use App\Models\PovertyCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\SurveysExport;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $query = PoorFamily::with(['neighborhood.village.district', 'surveyor']);

        // Apply filters
        if ($request->filled('village_id')) {
            $query->whereHas('neighborhood', function ($q) use ($request) {
                $q->where('village_id', $request->village_id);
            });
        }

        if ($request->filled('status')) {
            $query->where('status_verifikasi', $request->status);
        }

        if ($request->filled('poverty_level')) {
            $query->whereRaw('CASE 
                    WHEN poverty_score >= 20 THEN "Sangat Miskin"
                    WHEN poverty_score >= 15 THEN "Miskin" 
                    WHEN poverty_score >= 10 THEN "Rentan Miskin"
                    ELSE "Tidak Miskin" 
                    END = ?', [$request->poverty_level]);
        }

        if ($request->filled('surveyor_id')) {
            $query->where('surveyor_id', $request->surveyor_id);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $families = $query->paginate(20);
        $villages = Village::all();
        $surveyors = User::petugasLapangan()->active()->get();

        // Calculate summary statistics
        $summary = [
            'total' => $query->count(),
            'verified' => $query->clone()->where('status_verifikasi', 'verified')->count(),
            'pending' => $query->clone()->where('status_verifikasi', 'submitted')->count(),
            'rejected' => $query->clone()->where('status_verifikasi', 'rejected')->count(),
        ];

        return view('admin.reports', compact('families', 'villages', 'surveyors', 'summary'));
    }

    // ✅ Method reports untuk kompatibilitas dengan DashboardController
    public function reports(Request $request)
    {
        return $this->index($request);
    }

    public function export(Request $request)
    {
        $format = $request->get('format', 'pdf');

        $query = PoorFamily::with(['neighborhood.village.district', 'surveyor', 'categories']);

        // Apply same filters as index
        if ($request->filled('village_id')) {
            $query->whereHas('neighborhood', function ($q) use ($request) {
                $q->where('village_id', $request->village_id);
            });
        }

        if ($request->filled('status')) {
            $query->where('status_verifikasi', $request->status);
        }

        if ($request->filled('poverty_level')) {
            $query->whereRaw('CASE 
                    WHEN poverty_score >= 20 THEN "Sangat Miskin"
                    WHEN poverty_score >= 15 THEN "Miskin" 
                    WHEN poverty_score >= 10 THEN "Rentan Miskin"
                    ELSE "Tidak Miskin" 
                    END = ?', [$request->poverty_level]);
        }

        if ($request->filled('surveyor_id')) {
            $query->where('surveyor_id', $request->surveyor_id);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $families = $query->get();

        if ($format === 'pdf') {
            return $this->exportToPDF($families, $request);
        } elseif ($format === 'excel') {
            return $this->exportToExcel($families, $request);
        } else {
            return $this->exportToCSV($families, $request);
        }
    }

    // ✅ Method exportReport untuk route admin.reports.export
    public function exportReport(Request $request)
    {
        $format = $request->input('format', 'pdf');

        // Build query dengan filter
        $query = PoorFamily::with(['neighborhood.village.district', 'surveyor', 'categories']);

        // Apply filters
        if ($request->filled('village_id')) {
            $query->whereHas('neighborhood', function ($q) use ($request) {
                $q->where('village_id', $request->village_id);
            });
        }

        if ($request->filled('status')) {
            $query->where('status_verifikasi', $request->status);
        }

        if ($request->filled('poverty_level')) {
            $query->whereRaw('CASE 
                    WHEN poverty_score >= 20 THEN "Sangat Miskin"
                    WHEN poverty_score >= 15 THEN "Miskin" 
                    WHEN poverty_score >= 10 THEN "Rentan Miskin"
                    ELSE "Tidak Miskin" 
                    END = ?', [$request->poverty_level]);
        }

        if ($request->filled('surveyor_id')) {
            $query->where('surveyor_id', $request->surveyor_id);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $families = $query->get();

        $data = [
            'families' => $families,
            'title' => 'Laporan Data Survei Kemiskinan',
            'generated_at' => Carbon::now()->format('d/m/Y H:i:s'),
            'total_count' => $families->count(),
            'filters' => [
                'village' => $request->village_id ? Village::find($request->village_id)?->name : 'Semua Desa',
                'status' => $request->status ? ucfirst($request->status) : 'Semua Status',
                'poverty_level' => $request->poverty_level ?: 'Semua Kategori',
                'surveyor' => $request->surveyor_id ? User::find($request->surveyor_id)?->name : 'Semua Surveyor',
                'date_from' => $request->date_from,
                'date_to' => $request->date_to,
            ]
        ];

        if ($format === 'pdf') {
            return $this->exportPDF($data);
        } elseif ($format === 'excel') {
            return $this->exportExcel($data);
        }

        return redirect()->back()->with('error', 'Format tidak didukung');
    }

    public function summary(Request $request)
    {
        $dateFrom = $request->get('date_from', Carbon::now()->startOfMonth());
        $dateTo = $request->get('date_to', Carbon::now()->endOfMonth());

        $summary = [
            'overview' => [
                'total_families' => PoorFamily::whereBetween('created_at', [$dateFrom, $dateTo])->count(),
                'verified_families' => PoorFamily::verified()->whereBetween('created_at', [$dateFrom, $dateTo])->count(),
                'avg_poverty_score' => round(PoorFamily::verified()->whereBetween('created_at', [$dateFrom, $dateTo])->avg('poverty_score'), 2),
            ],
            'by_village' => $this->getSummaryByVillage($dateFrom, $dateTo),
            'by_category' => $this->getSummaryByCategory($dateFrom, $dateTo),
            'by_surveyor' => $this->getSummaryBySurveyor($dateFrom, $dateTo),
            'trends' => $this->getTrends($dateFrom, $dateTo),
        ];

        return response()->json($summary);
    }

    // ✅ Method exportToPDF yang diperbaiki dengan Laravel 12 syntax
    private function exportToPDF($families, $request)
    {
        $data = [
            'families' => $families,
            'title' => 'Laporan Data Survei Kemiskinan',
            'generated_at' => Carbon::now()->format('d/m/Y H:i:s'),
            'total_count' => $families->count(),
            'filters' => [
                'village' => $request->village_id ? Village::find($request->village_id)?->name : 'Semua Desa',
                'status' => $request->status ? ucfirst($request->status) : 'Semua Status',
                'poverty_level' => $request->poverty_level ?: 'Semua Kategori',
                'surveyor' => $request->surveyor_id ? User::find($request->surveyor_id)?->name : 'Semua Surveyor',
                'date_from' => $request->date_from,
                'date_to' => $request->date_to,
            ]
        ];

        $pdf = Pdf::loadView('admin.reports.pdf', $data)
            ->setPaper('A4', 'landscape')
            ->setOptions([
                'defaultFont' => 'sans-serif',
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled' => true,
            ]);

        return $pdf->download('laporan-kemiskinan-' . date('Y-m-d-H-i-s') . '.pdf');
    }

    // ✅ Method exportPDF untuk route admin.reports.export
    private function exportPDF($data)
    {
        $pdf = Pdf::loadView('admin.reports.pdf', $data)
            ->setPaper('a4', 'landscape')
            ->setOptions([
                'defaultFont' => 'sans-serif',
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled' => true,
            ]);

        $filename = 'laporan_survei_kemiskinan_' . date('Y-m-d_H-i-s') . '.pdf';

        return $pdf->download($filename);
    }

    // ✅ Method exportToExcel dengan Laravel Excel
    private function exportToExcel($families, $request)
    {
        $filters = [
            'village' => $request->village_id ? Village::find($request->village_id)?->name : 'Semua Desa',
            'status' => $request->status ? ucfirst($request->status) : 'Semua Status',
            'poverty_level' => $request->poverty_level ?: 'Semua Kategori',
            'surveyor' => $request->surveyor_id ? User::find($request->surveyor_id)?->name : 'Semua Surveyor',
            'date_from' => $request->date_from,
            'date_to' => $request->date_to,
        ];

        $filename = 'laporan-kemiskinan-' . date('Y-m-d-H-i-s') . '.xlsx';

        return Excel::download(new SurveysExport($families, $filters), $filename);
    }

    // ✅ Method exportExcel untuk route admin.reports.export
    private function exportExcel($data)
    {
        $filename = 'laporan_survei_kemiskinan_' . date('Y-m-d_H-i-s') . '.xlsx';

        return Excel::download(new SurveysExport($data['families'], $data['filters']), $filename);
    }

    private function exportToCSV($families, $request)
    {
        $filename = 'laporan-kemiskinan-' . date('Y-m-d-H-i-s') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        $callback = function () use ($families) {
            $file = fopen('php://output', 'w');

            // CSV Headers
            fputcsv($file, [
                'No',
                'Nama Kepala Keluarga',
                'NIK',
                'Alamat',
                'Desa',
                'Kecamatan',
                'Jumlah Anggota',
                'Jenis Kelamin KK',
                'Sumber Penghasilan',
                'Penghasilan Bulanan',
                'Jenis Bangunan',
                'Lantai Rumah',
                'Sumber Air',
                'Sumber Listrik',
                'Skor Kemiskinan',
                'Kategori Kemiskinan',
                'Status Verifikasi',
                'Surveyor',
                'Tanggal Survei',
                'Tanggal Verifikasi'
            ]);

            // CSV Data
            foreach ($families as $index => $family) {
                fputcsv($file, [
                    $index + 1,
                    $family->nama_kepala_keluarga,
                    $family->nik ?: '-',
                    $family->alamat_lengkap,
                    $family->neighborhood->village->name,
                    $family->neighborhood->village->district->name,
                    $family->jumlah_anggota_keluarga,
                    $family->jenis_kelamin_kk === 'L' ? 'Laki-laki' : 'Perempuan',
                    ucfirst(str_replace('_', ' ', $family->sumber_penghasilan)),
                    $family->penghasilan_bulanan ? 'Rp ' . number_format($family->penghasilan_bulanan) : '-',
                    ucfirst(str_replace('_', ' ', $family->jenis_bangunan)),
                    ucfirst($family->lantai_rumah),
                    strtoupper($family->sumber_air),
                    strtoupper(str_replace('_', ' ', $family->sumber_listrik)),
                    $family->poverty_score . '/25',
                    $family->poverty_level,
                    $family->status_text,
                    $family->surveyor->name,
                    $family->created_at->format('d/m/Y H:i'),
                    $family->verified_at ? $family->verified_at->format('d/m/Y H:i') : '-'
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    private function getSummaryByVillage($dateFrom, $dateTo)
    {
        return Village::withCount(['poorFamilies' => function ($query) use ($dateFrom, $dateTo) {
            $query->verified()->whereBetween('created_at', [$dateFrom, $dateTo]);
        }])->having('poor_families_count', '>', 0)->get();
    }

    private function getSummaryByCategory($dateFrom, $dateTo)
    {
        return PovertyCategory::whereHas('poorFamily', function ($query) use ($dateFrom, $dateTo) {
            $query->verified()->whereBetween('created_at', [$dateFrom, $dateTo]);
        })->selectRaw('kategori, AVG(skor) as avg_score, COUNT(*) as total')
            ->groupBy('kategori')
            ->get();
    }

    private function getSummaryBySurveyor($dateFrom, $dateTo)
    {
        return User::petugasLapangan()
            ->withCount(['surveys' => function ($query) use ($dateFrom, $dateTo) {
                $query->whereBetween('created_at', [$dateFrom, $dateTo]);
            }])
            ->having('surveys_count', '>', 0)
            ->get();
    }

    private function getTrends($dateFrom, $dateTo)
    {
        return PoorFamily::selectRaw('DATE(created_at) as date, COUNT(*) as total')
            ->whereBetween('created_at', [$dateFrom, $dateTo])
            ->groupBy('date')
            ->orderBy('date')
            ->get();
    }
}
