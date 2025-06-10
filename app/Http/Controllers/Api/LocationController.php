<?php
// app/Http/Controllers/Api/LocationController.php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Province;
use App\Models\Regency;
use App\Models\District;
use App\Models\Village;
use App\Models\Neighborhood;

class LocationController extends Controller
{
    public function provinces()
    {
        return response()->json(Province::all());
    }

    public function regencies(Province $province)
    {
        return response()->json($province->regencies);
    }

    public function districts(Regency $regency)
    {
        return response()->json($regency->districts);
    }

    public function villages(District $district)
    {
        return response()->json($district->villages);
    }

    public function neighborhoods(Village $village)
    {
        return response()->json($village->neighborhoods);
    }
}
