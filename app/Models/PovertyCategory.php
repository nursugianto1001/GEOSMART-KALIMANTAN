<?php
// app/Models/PovertyCategory.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PovertyCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'poor_family_id',
        'kategori',
        'skor',
        'keterangan'
    ];

    public function poorFamily()
    {
        return $this->belongsTo(PoorFamily::class);
    }
}
