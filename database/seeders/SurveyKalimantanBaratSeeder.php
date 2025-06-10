<?php
// database/seeders/SurveyKalimantanBaratSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PoorFamily;
use App\Models\Neighborhood;
use App\Models\User;
use App\Models\Village;
use App\Models\District;
use App\Models\Regency;
use App\Models\Province;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class SurveyKalimantanBaratSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('id_ID');
        
        // Disable foreign key checks untuk performa
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        
        $this->command->info('Seeding Survey Data untuk Kalimantan Barat...');
        
        // Ambil data Kalimantan Barat
        $kalbar = Province::where('code', '61')->first();
        if (!$kalbar) {
            $this->command->error('Province Kalimantan Barat tidak ditemukan. Jalankan IndonesiaLocationSeeder terlebih dahulu.');
            return;
        }
        
        // Ambil semua villages di Kalimantan Barat
        $villages = Village::whereHas('district.regency', function($query) use ($kalbar) {
            $query->where('province_id', $kalbar->id);
        })->get();
        
        if ($villages->isEmpty()) {
            $this->command->error('Villages Kalimantan Barat tidak ditemukan.');
            return;
        }
        
        // Ambil petugas lapangan
        $petugasLapangan = User::where('role', 'petugas_lapangan')->where('is_active', true)->get();
        if ($petugasLapangan->isEmpty()) {
            $this->command->error('Petugas lapangan tidak ditemukan. Jalankan AdminAndPetugasSeeder terlebih dahulu.');
            return;
        }
        
        $this->command->info('Creating neighborhoods...');
        $this->createNeighborhoods($villages, $faker);
        
        $this->command->info('Creating survey data...');
        $this->createSurveyData($villages, $petugasLapangan, $faker);
        
        // Re-enable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        
        $this->command->info('Survey Kalimantan Barat seeding completed!');
    }
    
    private function createNeighborhoods($villages, $faker)
    {
        foreach ($villages as $village) {
            // Buat 3-8 RT/RW per village
            $rtCount = $faker->numberBetween(3, 8);
            $rwCount = $faker->numberBetween(2, 4);
            
            for ($rw = 1; $rw <= $rwCount; $rw++) {
                for ($rt = 1; $rt <= $rtCount; $rt++) {
                    Neighborhood::firstOrCreate([
                        'village_id' => $village->id,
                        'rt' => str_pad($rt, 3, '0', STR_PAD_LEFT),
                        'rw' => str_pad($rw, 3, '0', STR_PAD_LEFT),
                    ]);
                }
            }
        }
    }
    
    private function createSurveyData($villages, $petugasLapangan, $faker)
    {
        $statusOptions = ['draft', 'submitted', 'verified', 'rejected'];
        $statusWeights = [10, 30, 50, 10]; // Persentase untuk setiap status
        
        $sumberPenghasilan = ['bertani', 'buruh', 'dagang', 'tidak_ada', 'lainnya'];
        $statusKepemilikan = ['milik_sendiri', 'sewa', 'tidak_punya'];
        $jenisBangunan = ['permanen', 'semi_permanen', 'tidak_layak'];
        $lantaiRumah = ['tanah', 'semen', 'keramik'];
        $dindingRumah = ['kayu', 'tembok', 'anyaman_bambu', 'seng'];
        $atapRumah = ['genteng', 'seng', 'rumbia', 'plastik'];
        $sumberAir = ['sumur', 'pdam', 'sungai'];
        $sumberListrik = ['pln', 'genset', 'tidak_ada'];
        $aksesSekolah = ['kurang_1km', '1_3km', 'lebih_3km'];
        $aksesKesehatan = ['puskesmas', 'rs', 'tidak_ada'];
        $aksesJalan = ['bisa_motor_mobil', 'tidak_bisa'];
        $statusKeluarga = ['tetap', 'pendatang', 'korban_bencana', 'lainnya'];
        $tipeTempat = ['rumah_pribadi', 'sewa', 'menumpang'];
        
        $asetOptions = ['motor', 'mobil', 'hp', 'tv', 'kulkas', 'mesin_cuci'];
        $bantuanOptions = ['pkh', 'bpnt', 'blt', 'kip', 'kis'];
        
        // Buat 200-300 survey untuk Kalimantan Barat
        $totalSurveys = $faker->numberBetween(200, 300);
        
        for ($i = 1; $i <= $totalSurveys; $i++) {
            // Pilih village random dari Kalimantan Barat
            $village = $villages->random();
            
            // Ambil neighborhood random dari village tersebut
            $neighborhood = Neighborhood::where('village_id', $village->id)->inRandomOrder()->first();
            
            if (!$neighborhood) {
                continue; // Skip jika tidak ada neighborhood
            }
            
            // Pilih petugas random
            $petugas = $petugasLapangan->random();
            
            // Pilih status berdasarkan weight
            $status = $faker->randomElement($statusOptions);
            
            // Generate data keluarga yang realistis untuk Kalimantan Barat
            $namaKepala = $this->generateNamaKalimantanBarat($faker);
            $jenisKelamin = $faker->randomElement(['L', 'P']);
            $jumlahAnggota = $faker->numberBetween(1, 8);
            
            // Generate koordinat yang realistis untuk Kalimantan Barat
            $coordinates = $this->generateKalimantanBaratCoordinates($faker);
            
            // Generate penghasilan berdasarkan kondisi ekonomi Kalimantan Barat
            $penghasilan = $this->generatePenghasilanKalbar($faker);
            
            // Generate data survey
            $survey = PoorFamily::create([
                'nama_kepala_keluarga' => $namaKepala,
                'nik' => $faker->optional(0.7)->numerify('################'), // 70% punya NIK
                'jumlah_anggota_keluarga' => $jumlahAnggota,
                'jenis_kelamin_kk' => $jenisKelamin,
                'status_keluarga' => $faker->randomElement($statusKeluarga),
                'neighborhood_id' => $neighborhood->id,
                'alamat_lengkap' => $this->generateAlamatKalbar($faker, $neighborhood),
                'latitude' => $coordinates['lat'],
                'longitude' => $coordinates['lng'],
                'tipe_tempat_tinggal' => $faker->randomElement($tipeTempat),
                'sumber_penghasilan' => $faker->randomElement($sumberPenghasilan),
                'penghasilan_bulanan' => $penghasilan,
                'status_kepemilikan' => $faker->randomElement($statusKepemilikan),
                'aset_utama' => $faker->randomElements($asetOptions, $faker->numberBetween(0, 4)),
                'jenis_bangunan' => $faker->randomElement($jenisBangunan),
                'luas_rumah' => $faker->optional(0.8)->numberBetween(20, 120),
                'lantai_rumah' => $faker->randomElement($lantaiRumah),
                'dinding_rumah' => $faker->randomElement($dindingRumah),
                'atap_rumah' => $faker->randomElement($atapRumah),
                'sumber_air' => $faker->randomElement($sumberAir),
                'sumber_listrik' => $faker->randomElement($sumberListrik),
                'akses_sekolah' => $faker->randomElement($aksesSekolah),
                'akses_kesehatan' => $faker->randomElement($aksesKesehatan),
                'akses_jalan' => $faker->randomElement($aksesJalan),
                'anak_tidak_sekolah' => $faker->boolean(30), // 30% kemungkinan ada anak tidak sekolah
                'ada_difabel_lansia' => $faker->boolean(25), // 25% kemungkinan ada difabel/lansia
                'ada_sakit_menahun' => $faker->boolean(20), // 20% kemungkinan ada sakit menahun
                'bantuan_pemerintah' => $faker->randomElements($bantuanOptions, $faker->numberBetween(0, 3)),
                'foto_depan_rumah' => $faker->optional(0.6)->imageUrl(640, 480, 'house'),
                'foto_dalam_rumah' => $faker->optional(0.4)->imageUrl(640, 480, 'interior'),
                'catatan_tambahan' => $faker->optional(0.3)->sentence(10),
                'surveyor_id' => $petugas->id,
                'status_verifikasi' => $status,
                'verified_by' => $status === 'verified' ? 1 : null, // Admin ID 1
                'verified_at' => $status === 'verified' ? $faker->dateTimeBetween('-30 days', 'now') : null,
                'rejection_reason' => $status === 'rejected' ? $faker->sentence(8) : null,
                'created_at' => $faker->dateTimeBetween('-6 months', 'now'),
                'updated_at' => $faker->dateTimeBetween('-1 month', 'now'),
            ]);
            
            if ($i % 50 == 0) {
                $this->command->info("Created {$i} surveys...");
            }
        }
    }
    
    private function generateNamaKalimantanBarat($faker)
    {
        $namaDepan = [
            'Ahmad', 'Budi', 'Siti', 'Dewi', 'Andi', 'Sari', 'Joko', 'Rina',
            'Agus', 'Lina', 'Hendra', 'Maya', 'Dedi', 'Fitri', 'Rudi', 'Indah',
            'Bambang', 'Yanti', 'Eko', 'Wati', 'Sutrisno', 'Endang', 'Wahyu', 'Sinta'
        ];
        
        $namaBelakang = [
            'Santoso', 'Wijaya', 'Sari', 'Pratama', 'Kusuma', 'Handoko', 'Lestari',
            'Permana', 'Suharto', 'Rahayu', 'Setiawan', 'Maharani', 'Gunawan', 'Safitri'
        ];
        
        return $faker->randomElement($namaDepan) . ' ' . $faker->randomElement($namaBelakang);
    }
    
    private function generateKalimantanBaratCoordinates($faker)
    {
        // Koordinat untuk Kalimantan Barat
        // Pontianak: -0.0263, 109.3425
        // Singkawang: 0.9063, 108.9896
        // Sambas: 1.3735, 109.3074
        
        return [
            'lat' => $faker->randomFloat(6, -1.5, 2.0), // Range latitude Kalimantan Barat
            'lng' => $faker->randomFloat(6, 108.0, 111.0) // Range longitude Kalimantan Barat
        ];
    }
    
    private function generatePenghasilanKalbar($faker)
    {
        // Penghasilan realistis untuk Kalimantan Barat
        $ranges = [
            [500000, 1500000],   // 40% - Penghasilan rendah
            [1500000, 3000000],  // 35% - Penghasilan menengah
            [3000000, 6000000],  // 20% - Penghasilan tinggi
            [6000000, 12000000]  // 5% - Penghasilan sangat tinggi
        ];
        
        $weights = [40, 35, 20, 5];
        $selectedRange = $faker->randomElement($ranges);
        
        return $faker->numberBetween($selectedRange[0], $selectedRange[1]);
    }
    
    private function generateAlamatKalbar($faker, $neighborhood)
    {
        $jalanTypes = ['Jl.', 'Gang', 'Lorong', 'Komplek'];
        $jalanNames = [
            'Merdeka', 'Sudirman', 'Diponegoro', 'Gajah Mada', 'Ahmad Yani',
            'Veteran', 'Pahlawan', 'Sungai Kapuas', 'Equator', 'Tanjungpura',
            'Pontianak', 'Singkawang', 'Sambas', 'Ketapang', 'Sintang'
        ];
        
        $jalan = $faker->randomElement($jalanTypes) . ' ' . $faker->randomElement($jalanNames);
        $nomor = $faker->numberBetween(1, 200);
        
        return "{$jalan} No. {$nomor}, RT {$neighborhood->rt}/RW {$neighborhood->rw}";
    }
}
