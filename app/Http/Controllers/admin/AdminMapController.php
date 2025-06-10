<?php
// app/Http/Controllers/Admin/AdminMapController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PoorFamily;
use App\Models\Village;
use App\Models\PublicFacility;
use App\Models\MainRoad;

class AdminMapController extends Controller
{
    public function index()
    {
        $allSurveys = PoorFamily::with([
            'neighborhood.village.district.regency.province',
            'surveyor'
        ])->get();

        $publicFacilities = PublicFacility::with('village')->get();
        $mainRoads = MainRoad::with('village')->get();
        $villages = Village::withCount(['poorFamilies as total_poor_families' => function($query) {
            $query->where('status_verifikasi', 'verified');
        }])->get();

        return view('admin.surveys.map', compact(
            'allSurveys',
            'publicFacilities',
            'mainRoads',
            'villages'
        ));
    }
}
