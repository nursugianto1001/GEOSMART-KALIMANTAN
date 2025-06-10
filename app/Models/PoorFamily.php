<?php
// app/Models/PoorFamily.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PoorFamily extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_kepala_keluarga',
        'nik',
        'jumlah_anggota_keluarga',
        'jenis_kelamin_kk',
        'status_keluarga',
        'neighborhood_id',
        'alamat_lengkap',
        'latitude',
        'longitude',
        'tipe_tempat_tinggal',
        'sumber_penghasilan',
        'penghasilan_bulanan',
        'status_kepemilikan',
        'aset_utama',
        'jenis_bangunan',
        'luas_rumah',
        'lantai_rumah',
        'dinding_rumah',
        'atap_rumah',
        'sumber_air',
        'sumber_listrik',
        'akses_sekolah',
        'akses_kesehatan',
        'akses_jalan',
        'anak_tidak_sekolah',
        'ada_difabel_lansia',
        'ada_sakit_menahun',
        'bantuan_pemerintah',
        'foto_depan_rumah',
        'foto_dalam_rumah',
        'catatan_tambahan',
        'surveyor_id',
        'status_verifikasi',
        'verified_by',
        'verified_at',
        'rejection_reason'
    ];

    protected function casts(): array
    {
        return [
            'aset_utama' => 'array',
            'bantuan_pemerintah' => 'array',
            'anak_tidak_sekolah' => 'boolean',
            'ada_difabel_lansia' => 'boolean',
            'ada_sakit_menahun' => 'boolean',
            'verified_at' => 'datetime',
            'latitude' => 'decimal:8',
            'longitude' => 'decimal:8',
            'penghasilan_bulanan' => 'decimal:2',
        ];
    }

    // Relationships
    public function neighborhood()
    {
        return $this->belongsTo(Neighborhood::class);
    }

    public function surveyor()
    {
        return $this->belongsTo(User::class, 'surveyor_id');
    }

    public function verifier()
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    public function categories()
    {
        return $this->hasMany(PovertyCategory::class);
    }

    // Scopes
    public function scopeVerified($query)
    {
        return $query->where('status_verifikasi', 'verified');
    }

    public function scopeSubmitted($query)
    {
        return $query->where('status_verifikasi', 'submitted');
    }

    public function scopeDraft($query)
    {
        return $query->where('status_verifikasi', 'draft');
    }

    public function scopeInArea($query, $lat, $lng, $radius = 5)
    {
        return $query->selectRaw("
            *, (
                6371 * acos(
                    cos(radians(?)) * 
                    cos(radians(latitude)) * 
                    cos(radians(longitude) - radians(?)) + 
                    sin(radians(?)) * 
                    sin(radians(latitude))
                )
            ) AS distance
        ", [$lat, $lng, $lat])
        ->having('distance', '<', $radius)
        ->orderBy('distance');
    }

    // Helper methods
    public function getStatusBadgeAttribute()
    {
        $badges = [
            'draft' => 'bg-gray-100 text-gray-800',
            'submitted' => 'bg-yellow-100 text-yellow-800',
            'verified' => 'bg-green-100 text-green-800',
            'rejected' => 'bg-red-100 text-red-800'
        ];

        return $badges[$this->status_verifikasi] ?? 'bg-gray-100 text-gray-800';
    }

    public function getStatusTextAttribute()
    {
        $texts = [
            'draft' => 'Draft',
            'submitted' => 'Menunggu Verifikasi',
            'verified' => 'Terverifikasi',
            'rejected' => 'Ditolak'
        ];

        return $texts[$this->status_verifikasi] ?? 'Unknown';
    }

    public function getPovertyScoreAttribute()
    {
        $score = 0;
        
        // Economic score
        if ($this->sumber_penghasilan === 'tidak_ada') $score += 5;
        elseif ($this->penghasilan_bulanan < 1000000) $score += 3;
        elseif ($this->penghasilan_bulanan < 2000000) $score += 2;
        else $score += 1;
        
        // Housing score
        if ($this->jenis_bangunan === 'tidak_layak') $score += 5;
        elseif ($this->jenis_bangunan === 'semi_permanen') $score += 3;
        else $score += 1;
        
        // Infrastructure score
        if ($this->sumber_air === 'sungai') $score += 3;
        if ($this->sumber_listrik === 'tidak_ada') $score += 3;
        if ($this->lantai_rumah === 'tanah') $score += 2;
        
        // Access score
        if ($this->akses_kesehatan === 'tidak_ada') $score += 3;
        if ($this->akses_sekolah === 'lebih_3km') $score += 2;
        
        // Social score
        if ($this->anak_tidak_sekolah) $score += 3;
        if ($this->ada_sakit_menahun) $score += 2;
        if ($this->ada_difabel_lansia) $score += 2;
        
        return min($score, 25); // Max score 25
    }

    public function getPovertyLevelAttribute()
    {
        $score = $this->poverty_score;
        
        if ($score >= 20) return 'Sangat Miskin';
        elseif ($score >= 15) return 'Miskin';
        elseif ($score >= 10) return 'Rentan Miskin';
        else return 'Tidak Miskin';
    }
}
