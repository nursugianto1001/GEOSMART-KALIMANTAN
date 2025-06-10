<?php
// app/Models/MainRoad.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MainRoad extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'village_id',
        'kondisi_jalan',
        'jenis_jalan',
        'lebar_jalan',
        'coordinates'
    ];

    protected function casts(): array
    {
        return [
            'coordinates' => 'array',
            'lebar_jalan' => 'decimal:2',
        ];
    }

    public function village()
    {
        return $this->belongsTo(Village::class);
    }
}
