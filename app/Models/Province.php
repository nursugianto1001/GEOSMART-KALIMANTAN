<?php
// app/Models/Province.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    protected $fillable = ['code', 'name'];

    public function regencies()
    {
        return $this->hasMany(Regency::class);
    }

    public function districts()
    {
        return $this->hasManyThrough(District::class, Regency::class);
    }

    // ✅ PERBAIKAN: Relationship yang benar untuk villages
    public function villages()
    {
        return $this->hasManyThrough(
            Village::class,
            District::class,
            'regency_id',    // Foreign key on districts table
            'district_id',   // Foreign key on villages table
            'id',           // Local key on provinces table
            'id'            // Local key on districts table
        )->join('regencies', 'districts.regency_id', '=', 'regencies.id')
         ->where('regencies.province_id', $this->id);
    }

    // ✅ ALTERNATIF: Gunakan relationship yang lebih sederhana
    public function getAllVillages()
    {
        return Village::whereHas('district.regency', function($query) {
            $query->where('province_id', $this->id);
        });
    }
}
