<?php
// app/Models/PublicFacility.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PublicFacility extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'type',
        'village_id',
        'latitude',
        'longitude',
        'alamat',
        'kondisi'
    ];

    protected function casts(): array
    {
        return [
            'latitude' => 'decimal:8',
            'longitude' => 'decimal:8',
        ];
    }

    public function village()
    {
        return $this->belongsTo(Village::class);
    }
}
