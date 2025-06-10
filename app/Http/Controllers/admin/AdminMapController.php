<?php
// app/Http/Controllers/Admin/AdminMapController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PoorFamily;
use App\Models\Village;
use App\Models\PublicFacility;
use App\Models\MainRoad;
use App\Models\Province;
use App\Models\Regency;
use App\Models\District;
use App\Models\Neighborhood;

class AdminMapController extends Controller
{
    public function index()
    {
        // ✅ Ambil semua data dari database sesuai migration
        $allSurveys = PoorFamily::with([
            'neighborhood.village.district.regency.province',
            'surveyor',
            'verifier',
            'categories'
        ])->whereNotNull('latitude')->whereNotNull('longitude')->get();

        // ✅ Data geografis lengkap
        $provinces = Province::with('regencies.districts.villages')->get();
        $regencies = Regency::with('province', 'districts.villages')->get();
        $districts = District::with('regency.province', 'villages')->get();
        $villages = Village::with('district.regency.province')
                          ->withCount(['poorFamilies as total_poor_families' => function($query) {
                              $query->where('status_verifikasi', 'verified');
                          }])
                          ->get();

        // ✅ Data neighborhoods (RT/RW)
        $neighborhoods = Neighborhood::with('village.district.regency.province')->get();

        // ✅ Data fasilitas umum (jika ada)
        $publicFacilities = PublicFacility::with('village.district.regency.province')->get();

        // ✅ Data jalan utama (jika ada)
        $mainRoads = MainRoad::with('village.district.regency.province')->get();

        // ✅ Statistik lengkap
        $statistics = [
            'total_provinces' => $provinces->count(),
            'total_regencies' => $regencies->count(),
            'total_districts' => $districts->count(),
            'total_villages' => $villages->count(),
            'total_neighborhoods' => $neighborhoods->count(),
            'total_surveys' => $allSurveys->count(),
            'total_facilities' => $publicFacilities->count(),
            'total_roads' => $mainRoads->count(),
            'verified_surveys' => $allSurveys->where('status_verifikasi', 'verified')->count(),
            'pending_surveys' => $allSurveys->where('status_verifikasi', 'submitted')->count(),
        ];

        return view('admin.surveys.map', compact(
            'allSurveys',
            'provinces',
            'regencies', 
            'districts',
            'villages',
            'neighborhoods',
            'publicFacilities',
            'mainRoads',
            'statistics'
        ));
    }
}
