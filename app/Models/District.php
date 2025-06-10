<?php
// app/Models/District.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    protected $fillable = ['regency_id', 'code', 'name'];

    public function regency()
    {
        return $this->belongsTo(Regency::class);
    }

    public function province()
    {
        return $this->hasOneThrough(
            Province::class,
            Regency::class,
            'id',           // Foreign key on regencies table
            'id',           // Foreign key on provinces table  
            'regency_id',   // Local key on districts table
            'province_id'   // Local key on regencies table
        );
    }

    public function villages()
    {
        return $this->hasMany(Village::class);
    }
}
