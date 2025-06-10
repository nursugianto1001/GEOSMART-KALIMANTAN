<?php
// app/Models/Village.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Village extends Model
{
    protected $fillable = ['district_id', 'code', 'name'];

    public function district()
    {
        return $this->belongsTo(District::class);
    }

    public function regency()
    {
        return $this->hasOneThrough(Regency::class, District::class, 'id', 'id', 'district_id', 'regency_id');
    }

    public function province()
    {
        return $this->hasOneThrough(Province::class, District::class, 'id', 'province_id', 'district_id', 'regency_id');
    }

    public function neighborhoods()
    {
        return $this->hasMany(Neighborhood::class);
    }

    public function poorFamilies()
    {
        return $this->hasManyThrough(PoorFamily::class, Neighborhood::class);
    }

    // ✅ Tambahkan relationship untuk main roads dan public facilities
    public function mainRoads()
    {
        return $this->hasMany(MainRoad::class);
    }

    public function publicFacilities()
    {
        return $this->hasMany(PublicFacility::class);
    }
}
