<?php
// database/seeders/PublicFacilitiesSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PublicFacility;
use App\Models\Village;
use Faker\Factory as Faker;

class PublicFacilitiesSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('id_ID');
        
        // Ambil villages dari Kalimantan Barat saja
        $villages = Village::whereHas('district.regency.province', function($query) {
            $query->where('code', '61'); // Kalimantan Barat
        })->get();

        $facilityTypes = ['sekolah', 'puskesmas', 'kantor_desa', 'masjid', 'pasar'];

        foreach ($villages as $village) {
            // 2-4 fasilitas per village
            $facilityCount = $faker->numberBetween(2, 4);
            
            for ($i = 1; $i <= $facilityCount; $i++) {
                $type = $faker->randomElement($facilityTypes);
                
                // Generate koordinat berdasarkan regency yang akurat
                $coordinates = $this->generateFacilityCoordinates($village, $faker);
                
                PublicFacility::create([
                    'name' => $this->generateFacilityName($type, $village->name, $faker),
                    'type' => $type,
                    'village_id' => $village->id,
                    'latitude' => $coordinates['lat'],
                    'longitude' => $coordinates['lng'],
                    'alamat' => $this->generateFacilityAddress($village, $faker),
                    'kondisi' => $faker->randomElement(['baik', 'sedang', 'rusak'])
                ]);
            }
        }
    }
    
    private function generateFacilityName($type, $villageName, $faker)
    {
        $names = [
            'sekolah' => ['SDN', 'SMPN', 'SMAN', 'MIS', 'MTs', 'MA'],
            'puskesmas' => ['Puskesmas', 'Pustu', 'Poskesdes'],
            'kantor_desa' => ['Kantor Desa', 'Balai Desa'],
            'masjid' => ['Masjid Al-Ikhlas', 'Masjid Nur', 'Masjid Jami', 'Masjid Baitul'],
            'pasar' => ['Pasar', 'Pasar Tradisional', 'Pasar Desa']
        ];
        
        $prefix = $faker->randomElement($names[$type]);
        return $prefix . ' ' . $villageName;
    }
    
    private function generateFacilityAddress($village, $faker)
    {
        $jalanTypes = ['Jl.', 'Gang', 'Lorong'];
        $jalanNames = [
            'Merdeka', 'Sudirman', 'Diponegoro', 'Ahmad Yani',
            'Veteran', 'Pahlawan', 'Sungai Kapuas', 'Equator'
        ];
        
        $jalan = $faker->randomElement($jalanTypes) . ' ' . $faker->randomElement($jalanNames);
        $nomor = $faker->numberBetween(1, 50);
        
        return "{$jalan} No. {$nomor}, Desa {$village->name}";
    }
    
    private function generateFacilityCoordinates($village, $faker)
    {
        // Koordinat akurat berdasarkan regency di Kalimantan Barat
        $regencyCoords = $this->getRegencyCoordinates($village->district->regency->name);
        
        // Variasi kecil dari center regency (radius ~3km untuk fasilitas)
        $latVariation = $faker->randomFloat(6, -0.03, 0.03);
        $lngVariation = $faker->randomFloat(6, -0.03, 0.03);
        
        return [
            'lat' => $regencyCoords['lat'] + $latVariation,
            'lng' => $regencyCoords['lng'] + $lngVariation
        ];
    }
    
    private function getRegencyCoordinates($regencyName)
    {
        // Koordinat akurat untuk setiap kabupaten/kota di Kalimantan Barat
        $coordinates = [
            // Kota
            'KOTA PONTIANAK' => ['lat' => -0.02055556, 'lng' => 109.34138889],
            'KOTA SINGKAWANG' => ['lat' => 0.9, 'lng' => 108.98333333],
            
            // Kabupaten
            'KABUPATEN SAMBAS' => ['lat' => 1.43333, 'lng' => 109.35],
            'KABUPATEN BENGKAYANG' => ['lat' => 1.06911, 'lng' => 109.66393],
            'KABUPATEN LANDAK' => ['lat' => 0.42373, 'lng' => 109.75917],
            'KABUPATEN MEMPAWAH' => ['lat' => 0.25, 'lng' => 109.16667],
            'KABUPATEN SANGGAU' => ['lat' => 0.11944444, 'lng' => 110.58888889],
            'KABUPATEN KETAPANG' => ['lat' => -1.85, 'lng' => 109.98333],
            'KABUPATEN SINTANG' => ['lat' => 0.06805556, 'lng' => 111.49805556],
            'KABUPATEN KAPUAS HULU' => ['lat' => 0.83333, 'lng' => 112.8],
            'KABUPATEN SEKADAU' => ['lat' => 0.03485, 'lng' => 110.95066],
            'KABUPATEN MELAWI' => ['lat' => -0.33617, 'lng' => 111.698],
            'KABUPATEN KAYONG UTARA' => ['lat' => -1.06023, 'lng' => 110.10402],
            'KABUPATEN KUBU RAYA' => ['lat' => -0.31924, 'lng' => 109.51865],
        ];
        
        // Return koordinat atau default ke Pontianak jika tidak ditemukan
        return $coordinates[$regencyName] ?? ['lat' => -0.02055556, 'lng' => 109.34138889];
    }
}
