<?php
// app/Models/Neighborhood.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Neighborhood extends Model
{
    use HasFactory;

    protected $fillable = ['rt', 'rw', 'village_id'];

    // ✅ Relationships
    public function village()
    {
        return $this->belongsTo(Village::class);
    }

    public function poorFamilies()
    {
        return $this->hasMany(PoorFamily::class);
    }

    // ✅ Accessors
    public function getFullAddressAttribute()
    {
        return "RT {$this->rt}/RW {$this->rw}, {$this->village->name}, {$this->village->district->name}";
    }

    public function getFormattedRtAttribute()
    {
        return str_pad($this->rt, 3, '0', STR_PAD_LEFT);
    }

    public function getFormattedRwAttribute()
    {
        return str_pad($this->rw, 3, '0', STR_PAD_LEFT);
    }

    public function getShortAddressAttribute()
    {
        return "RT {$this->formatted_rt}/RW {$this->formatted_rw}";
    }

    // ✅ Static Methods untuk Auto-Create dan Validation
    public static function findOrCreate($rt, $rw, $villageId)
    {
        $rtFormatted = str_pad($rt, 3, '0', STR_PAD_LEFT);
        $rwFormatted = str_pad($rw, 3, '0', STR_PAD_LEFT);

        return static::firstOrCreate([
            'rt' => $rtFormatted,
            'rw' => $rwFormatted,
            'village_id' => $villageId
        ]);
    }

    public static function findOrCreateByInput($rt, $rw, $villageId)
    {
        // Clean input dan format
        $rtCleaned = preg_replace('/\D/', '', $rt); // Remove non-digits
        $rwCleaned = preg_replace('/\D/', '', $rw); // Remove non-digits
        
        $rtFormatted = str_pad($rtCleaned, 3, '0', STR_PAD_LEFT);
        $rwFormatted = str_pad($rwCleaned, 3, '0', STR_PAD_LEFT);

        return static::firstOrCreate([
            'rt' => $rtFormatted,
            'rw' => $rwFormatted,
            'village_id' => $villageId
        ]);
    }

    public static function validateRtRw($rt, $rw)
    {
        // RT/RW harus berupa angka 1-3 digit
        $rtValid = preg_match('/^[0-9]{1,3}$/', $rt);
        $rwValid = preg_match('/^[0-9]{1,3}$/', $rw);
        
        // Validasi range (1-999)
        $rtNum = intval($rt);
        $rwNum = intval($rw);
        
        $rtRange = $rtNum >= 1 && $rtNum <= 999;
        $rwRange = $rwNum >= 1 && $rwNum <= 999;
        
        return $rtValid && $rwValid && $rtRange && $rwRange;
    }

    public static function formatRtRw($rt, $rw)
    {
        return [
            'rt' => str_pad($rt, 3, '0', STR_PAD_LEFT),
            'rw' => str_pad($rw, 3, '0', STR_PAD_LEFT)
        ];
    }

    // ✅ Scopes untuk Query
    public function scopeByVillage($query, $villageId)
    {
        return $query->where('village_id', $villageId);
    }

    public function scopeByRtRw($query, $rt, $rw)
    {
        $formatted = static::formatRtRw($rt, $rw);
        return $query->where('rt', $formatted['rt'])
                    ->where('rw', $formatted['rw']);
    }

    public function scopeInVillages($query, array $villageIds)
    {
        return $query->whereIn('village_id', $villageIds);
    }

    public function scopeOrderedByRtRw($query)
    {
        return $query->orderBy('rt')->orderBy('rw');
    }

    // ✅ Helper Methods
    public function getSurveyCountAttribute()
    {
        return $this->poorFamilies()->count();
    }

    public function getVerifiedSurveyCountAttribute()
    {
        return $this->poorFamilies()->where('status_verifikasi', 'verified')->count();
    }

    public function hasSurveys()
    {
        return $this->poorFamilies()->exists();
    }

    public function isInVillage($villageId)
    {
        return $this->village_id == $villageId;
    }

    // ✅ Static Helper untuk Suggestions
    public static function getNextRtForVillage($villageId)
    {
        $lastNeighborhood = static::byVillage($villageId)
                                  ->orderBy('rt', 'desc')
                                  ->first();
        
        if (!$lastNeighborhood) {
            return '001';
        }

        $nextRt = intval($lastNeighborhood->rt) + 1;
        return str_pad($nextRt, 3, '0', STR_PAD_LEFT);
    }

    public static function getNextRwForVillage($villageId)
    {
        $lastNeighborhood = static::byVillage($villageId)
                                  ->orderBy('rw', 'desc')
                                  ->first();
        
        if (!$lastNeighborhood) {
            return '001';
        }

        $nextRw = intval($lastNeighborhood->rw) + 1;
        return str_pad($nextRw, 3, '0', STR_PAD_LEFT);
    }

    public static function getRtRwListForVillage($villageId)
    {
        return static::byVillage($villageId)
                     ->orderedByRtRw()
                     ->get(['rt', 'rw'])
                     ->map(function ($neighborhood) {
                         return [
                             'rt' => $neighborhood->rt,
                             'rw' => $neighborhood->rw,
                             'display' => "RT {$neighborhood->rt}/RW {$neighborhood->rw}"
                         ];
                     });
    }

    // ✅ Validation Rules untuk Form Request
    public static function getValidationRules($isUpdate = false, $currentId = null)
    {
        $rules = [
            'rt' => [
                'required',
                'string',
                'max:3',
                'regex:/^[0-9]{1,3}$/',
                function ($attribute, $value, $fail) {
                    $numValue = intval($value);
                    if ($numValue < 1 || $numValue > 999) {
                        $fail('RT harus antara 001-999');
                    }
                },
            ],
            'rw' => [
                'required',
                'string',
                'max:3',
                'regex:/^[0-9]{1,3}$/',
                function ($attribute, $value, $fail) {
                    $numValue = intval($value);
                    if ($numValue < 1 || $numValue > 999) {
                        $fail('RW harus antara 001-999');
                    }
                },
            ],
            'village_id' => 'required|exists:villages,id'
        ];

        // Tambah unique rule jika diperlukan
        if (!$isUpdate) {
            $rules['rt'][] = function ($attribute, $value, $fail) use ($rules) {
                // Custom validation akan dihandle di controller
            };
        }

        return $rules;
    }
}
