<?php
// app/Policies/PoorFamilyPolicy.php

namespace App\Policies;

use App\Models\PoorFamily;
use App\Models\User;

class PoorFamilyPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->isAdmin() || $user->isPetugasLapangan();
    }

    public function view(User $user, PoorFamily $poorFamily): bool
    {
        return $user->isAdmin() || $user->id === $poorFamily->surveyor_id;
    }

    public function create(User $user): bool
    {
        return $user->isPetugasLapangan() && $user->is_active;
    }

    public function update(User $user, PoorFamily $poorFamily): bool
    {
        return $user->isPetugasLapangan() 
               && $user->id === $poorFamily->surveyor_id
               && in_array($poorFamily->status_verifikasi, ['draft', 'rejected']);
    }

    public function delete(User $user, PoorFamily $poorFamily): bool
    {
        return $user->isPetugasLapangan() 
               && $user->id === $poorFamily->surveyor_id
               && $poorFamily->status_verifikasi === 'draft';
    }

    public function verify(User $user, PoorFamily $poorFamily): bool
    {
        return $user->isAdmin() && $poorFamily->status_verifikasi === 'submitted';
    }

    public function reject(User $user, PoorFamily $poorFamily): bool
    {
        return $user->isAdmin() && $poorFamily->status_verifikasi === 'submitted';
    }
}
