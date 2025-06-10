<?php
// database/seeders/MainRoadsSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MainRoad;
use App\Models\Village;
use Faker\Factory as Faker;

class MainRoadsSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('id_ID');
        
        // Ambil villages dari Kalimantan Barat saja
        $villages = Village::whereHas('district.regency.province', function($query) {
            $query->where('code', '61'); // Kalimantan Barat
        })->get();

        foreach ($villages as $village) {
            // 1-2 jalan utama per village
            $roadCount = $faker->numberBetween(1, 2);
            
            for ($i = 1; $i <= $roadCount; $i++) {
                // Generate koordinat berdasarkan regency yang akurat
                $coordinates = $this->generateRoadCoordinates($village, $faker);
                
                MainRoad::create([
                    'name' => $this->generateRoadName($village, $faker),
                    'village_id' => $village->id,
                    'kondisi_jalan' => $faker->randomElement(['baik', 'sedang', 'rusak']),
                    'jenis_jalan' => $faker->randomElement(['aspal', 'beton', 'tanah', 'kerikil']),
                    'lebar_jalan' => $faker->randomFloat(2, 3, 12),
                    'coordinates' => json_encode($coordinates)
                ]);
            }
        }
    }
    
    private function generateRoadName($village, $faker)
    {
        $roadTypes = [
            'Jalan Raya ' . $village->name,
            'Jalan Provinsi ' . $village->name,
            'Jalan Kabupaten ' . $village->name,
            'Jalan Desa ' . $village->name,
            'Jalan Trans Kalimantan',
            'Jalan Lintas ' . $village->district->regency->name
        ];
        
        return $faker->randomElement($roadTypes);
    }
    
    private function generateRoadCoordinates($village, $faker)
    {
        // Koordinat akurat berdasarkan regency di Kalimantan Barat
        $regencyCoords = $this->getRegencyCoordinates($village->district->regency->name);
        
        // Generate 2-4 titik untuk membentuk jalan
        $points = [];
        $numPoints = $faker->numberBetween(2, 4);
        
        for ($i = 0; $i < $numPoints; $i++) {
            // Variasi kecil dari center regency (radius ~5km)
            $latVariation = $faker->randomFloat(6, -0.05, 0.05);
            $lngVariation = $faker->randomFloat(6, -0.05, 0.05);
            
            $points[] = [
                $regencyCoords['lat'] + $latVariation,
                $regencyCoords['lng'] + $lngVariation
            ];
        }
        
        return $points;
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
