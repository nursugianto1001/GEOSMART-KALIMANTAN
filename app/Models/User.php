<?php
// app/Models/User.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'phone',
        'nip',
        'is_active',
        'created_by'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
        ];
    }

    // Relationships
    public function surveys()
    {
        return $this->hasMany(PoorFamily::class, 'surveyor_id');
    }

    public function verifiedSurveys()
    {
        return $this->hasMany(PoorFamily::class, 'verified_by');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function createdUsers()
    {
        return $this->hasMany(User::class, 'created_by');
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopePetugasLapangan($query)
    {
        return $query->where('role', 'petugas_lapangan');
    }

    public function scopeAdmin($query)
    {
        return $query->where('role', 'admin');
    }

    // Helper methods
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isPetugasLapangan()
    {
        return $this->role === 'petugas_lapangan';
    }
}
