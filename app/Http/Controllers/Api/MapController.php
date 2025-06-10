<?php
// app/Http/Controllers/Api/MapController.php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PoorFamily;
use App\Models\PublicFacility;
use App\Models\MainRoad;
use Illuminate\Http\Request;

class MapController extends Controller
{
    public function poorFamilies(Request $request)
    {
        $query = PoorFamily::verified()
                          ->with('neighborhood.village');

        if ($request->has('bounds')) {
            $bounds = $request->bounds;
            $query->whereBetween('latitude', [$bounds['south'], $bounds['north']])
                  ->whereBetween('longitude', [$bounds['west'], $bounds['east']]);
        }

        $families = $query->get()->map(function($family) {
            return [
                'id' => $family->id,
                'name' => $family->nama_kepala_keluarga,
                'latitude' => $family->latitude,
                'longitude' => $family->longitude,
                'address' => $family->alamat_lengkap,
                'village' => $family->neighborhood->village->name,
                'economic_status' => $family->sumber_penghasilan,
                'house_condition' => $family->jenis_bangunan,
                'poverty_score' => $family->poverty_score,
                'poverty_level' => $family->poverty_level,
                'popup_content' => view('components.map-popup', compact('family'))->render()
            ];
        });

        return response()->json($families);
    }

    public function publicFacilities(Request $request)
    {
        $query = PublicFacility::with('village');

        if ($request->has('type')) {
            $query->where('type', $request->type);
        }

        if ($request->has('bounds')) {
            $bounds = $request->bounds;
            $query->whereBetween('latitude', [$bounds['south'], $bounds['north']])
                  ->whereBetween('longitude', [$bounds['west'], $bounds['east']]);
        }

        $facilities = $query->get()->map(function($facility) {
            return [
                'id' => $facility->id,
                'name' => $facility->name,
                'type' => $facility->type,
                'latitude' => $facility->latitude,
                'longitude' => $facility->longitude,
                'condition' => $facility->kondisi,
                'village' => $facility->village->name,
            ];
        });

        return response()->json($facilities);
    }

    public function mainRoads(Request $request)
    {
        $query = MainRoad::with('village');

        $roads = $query->get()->map(function($road) {
            return [
                'id' => $road->id,
                'name' => $road->name,
                'condition' => $road->kondisi_jalan,
                'type' => $road->jenis_jalan,
                'coordinates' => $road->coordinates,
                'village' => $road->village->name,
            ];
        });

        return response()->json($roads);
    }

    public function choroplethData()
    {
        $villageData = \App\Models\Village::with(['poorFamilies' => function($query) {
            $query->verified();
        }])->get()->map(function($village) {
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
            $colorIntensity = min($avgScore / 25, 1); // Normalize to 0-1
            
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
}
