<?php
// database/seeders/AdminAndPetugasSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminAndPetugasSeeder extends Seeder
{
    public function run(): void
    {
        // Create Admin User
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@kemiskinan.id',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'phone' => '081234567890',
            'nip' => null,
            // ✅ PERBAIKAN: Hapus wilayah_kerja karena kolom tidak ada lagi
            'is_active' => true,
            'created_by' => null,
        ]);

        // Create Petugas Lapangan Users
        $petugasData = [
            [
                'name' => 'Budi Santoso',
                'email' => 'budi@kemiskinan.id',
                'phone' => '081234567891',
                'nip' => '198501012010011001',
                'is_active' => true,
            ],
            [
                'name' => 'Siti Nurhaliza',
                'email' => 'siti@kemiskinan.id',
                'phone' => '081234567892',
                'nip' => '198502022010012002',
                'is_active' => true,
            ],
            [
                'name' => 'Ahmad Fauzi',
                'email' => 'ahmad@kemiskinan.id',
                'phone' => '081234567893',
                'nip' => '198503032010013003',
                'is_active' => true,
            ],
            [
                'name' => 'Dewi Sartika',
                'email' => 'dewi@kemiskinan.id',
                'phone' => '081234567894',
                'nip' => '198504042010014004',
                'is_active' => false, // Non-aktif untuk testing
            ],
            [
                'name' => 'Eko Prasetyo',
                'email' => 'eko@kemiskinan.id',
                'phone' => '081234567895',
                'nip' => '198505052010015005',
                'is_active' => true,
            ],
        ];

        foreach ($petugasData as $petugas) {
            User::create([
                'name' => $petugas['name'],
                'email' => $petugas['email'],
                'password' => Hash::make('password'),
                'role' => 'petugas_lapangan',
                'phone' => $petugas['phone'],
                'nip' => $petugas['nip'],
                // ✅ PERBAIKAN: Hapus wilayah_kerja - semua petugas akses penuh
                'is_active' => $petugas['is_active'],
                'created_by' => 1, // Created by admin
            ]);
        }

        $this->command->info('Created 1 admin and ' . count($petugasData) . ' petugas lapangan users');
        $this->command->info('All users have full access to all areas');
        $this->command->info('Default password for all users: password');
    }
}
