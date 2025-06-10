<?php
// database/seeders/IndonesiaLocationSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Province;
use App\Models\Regency;
use App\Models\District;
use App\Models\Village;
use Illuminate\Support\Facades\DB;

class IndonesiaLocationSeeder extends Seeder
{
    public function run(): void
    {
        // Disable foreign key checks untuk performa
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        
        // Truncate tables
        Village::truncate();
        District::truncate();
        Regency::truncate();
        Province::truncate();
        
        $this->command->info('Seeding Provinces...');
        $this->seedProvinces();
        
        $this->command->info('Seeding Regencies...');
        $this->seedRegencies();
        
        $this->command->info('Seeding Districts...');
        $this->seedDistricts();
        
        $this->command->info('Seeding Villages...');
        $this->seedVillages();
        
        // Re-enable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        
        $this->command->info('Kalimantan Barat location seeding completed!');
    }

    private function seedProvinces()
    {
        // ✅ PERBAIKAN: Hanya Kalimantan Barat
        $provinces = [
            ['code' => '61', 'name' => 'KALIMANTAN BARAT'],
        ];

        Province::insert($provinces);
    }

    private function seedRegencies()
    {
        // ✅ Gunakan dynamic province ID
        $kalbar = Province::where('code', '61')->first();

        $regencies = [
            // KALIMANTAN BARAT - Semua kabupaten/kota
            ['code' => '6101', 'name' => 'KABUPATEN SAMBAS', 'province_id' => $kalbar->id],
            ['code' => '6102', 'name' => 'KABUPATEN BENGKAYANG', 'province_id' => $kalbar->id],
            ['code' => '6103', 'name' => 'KABUPATEN LANDAK', 'province_id' => $kalbar->id],
            ['code' => '6104', 'name' => 'KABUPATEN MEMPAWAH', 'province_id' => $kalbar->id],
            ['code' => '6105', 'name' => 'KABUPATEN SANGGAU', 'province_id' => $kalbar->id],
            ['code' => '6106', 'name' => 'KABUPATEN KETAPANG', 'province_id' => $kalbar->id],
            ['code' => '6107', 'name' => 'KABUPATEN SINTANG', 'province_id' => $kalbar->id],
            ['code' => '6108', 'name' => 'KABUPATEN KAPUAS HULU', 'province_id' => $kalbar->id],
            ['code' => '6109', 'name' => 'KABUPATEN SEKADAU', 'province_id' => $kalbar->id],
            ['code' => '6110', 'name' => 'KABUPATEN MELAWI', 'province_id' => $kalbar->id],
            ['code' => '6111', 'name' => 'KABUPATEN KAYONG UTARA', 'province_id' => $kalbar->id],
            ['code' => '6112', 'name' => 'KABUPATEN KUBU RAYA', 'province_id' => $kalbar->id],
            ['code' => '6171', 'name' => 'KOTA PONTIANAK', 'province_id' => $kalbar->id],
            ['code' => '6172', 'name' => 'KOTA SINGKAWANG', 'province_id' => $kalbar->id],
        ];

        Regency::insert($regencies);
    }

    private function seedDistricts()
    {
        // ✅ Gunakan dynamic regency ID - Semua kecamatan di Kalimantan Barat
        $pontianak = Regency::where('code', '6171')->first();
        $singkawang = Regency::where('code', '6172')->first();
        $sambas = Regency::where('code', '6101')->first();
        $bengkayang = Regency::where('code', '6102')->first();
        $landak = Regency::where('code', '6103')->first();
        $mempawah = Regency::where('code', '6104')->first();
        $sanggau = Regency::where('code', '6105')->first();
        $ketapang = Regency::where('code', '6106')->first();
        $sintang = Regency::where('code', '6107')->first();
        $kapuas_hulu = Regency::where('code', '6108')->first();
        $sekadau = Regency::where('code', '6109')->first();
        $melawi = Regency::where('code', '6110')->first();
        $kayong_utara = Regency::where('code', '6111')->first();
        $kubu_raya = Regency::where('code', '6112')->first();

        $districts = [
            // KOTA PONTIANAK
            ['code' => '617101', 'name' => 'PONTIANAK KOTA', 'regency_id' => $pontianak->id],
            ['code' => '617102', 'name' => 'PONTIANAK SELATAN', 'regency_id' => $pontianak->id],
            ['code' => '617103', 'name' => 'PONTIANAK TIMUR', 'regency_id' => $pontianak->id],
            ['code' => '617104', 'name' => 'PONTIANAK UTARA', 'regency_id' => $pontianak->id],
            ['code' => '617105', 'name' => 'PONTIANAK BARAT', 'regency_id' => $pontianak->id],
            ['code' => '617106', 'name' => 'PONTIANAK TENGGARA', 'regency_id' => $pontianak->id],

            // KOTA SINGKAWANG
            ['code' => '617201', 'name' => 'SINGKAWANG BARAT', 'regency_id' => $singkawang->id],
            ['code' => '617202', 'name' => 'SINGKAWANG TENGAH', 'regency_id' => $singkawang->id],
            ['code' => '617203', 'name' => 'SINGKAWANG TIMUR', 'regency_id' => $singkawang->id],
            ['code' => '617204', 'name' => 'SINGKAWANG UTARA', 'regency_id' => $singkawang->id],
            ['code' => '617205', 'name' => 'SINGKAWANG SELATAN', 'regency_id' => $singkawang->id],

            // KABUPATEN SAMBAS
            ['code' => '610101', 'name' => 'SAMBAS', 'regency_id' => $sambas->id],
            ['code' => '610102', 'name' => 'TEBAS', 'regency_id' => $sambas->id],
            ['code' => '610103', 'name' => 'PEMANGKAT', 'regency_id' => $sambas->id],
            ['code' => '610104', 'name' => 'SAJINGAN BESAR', 'regency_id' => $sambas->id],
            ['code' => '610105', 'name' => 'SEJANGKUNG', 'regency_id' => $sambas->id],
            ['code' => '610106', 'name' => 'SELAKAU', 'regency_id' => $sambas->id],
            ['code' => '610107', 'name' => 'PALOH', 'regency_id' => $sambas->id],

            // KABUPATEN BENGKAYANG
            ['code' => '610201', 'name' => 'BENGKAYANG', 'regency_id' => $bengkayang->id],
            ['code' => '610202', 'name' => 'SAMALANTAN', 'regency_id' => $bengkayang->id],
            ['code' => '610203', 'name' => 'SANGGAU LEDO', 'regency_id' => $bengkayang->id],
            ['code' => '610204', 'name' => 'JAGOI BABANG', 'regency_id' => $bengkayang->id],
            ['code' => '610205', 'name' => 'SELUAS', 'regency_id' => $bengkayang->id],
            ['code' => '610206', 'name' => 'MONTERADO', 'regency_id' => $bengkayang->id],

            // KABUPATEN LANDAK
            ['code' => '610301', 'name' => 'NGABANG', 'regency_id' => $landak->id],
            ['code' => '610302', 'name' => 'MENJALIN', 'regency_id' => $landak->id],
            ['code' => '610303', 'name' => 'MEMPAWAH HULU', 'regency_id' => $landak->id],
            ['code' => '610304', 'name' => 'SENGAH TEMILA', 'regency_id' => $landak->id],
            ['code' => '610305', 'name' => 'AIR BESAR', 'regency_id' => $landak->id],

            // KABUPATEN MEMPAWAH
            ['code' => '610401', 'name' => 'MEMPAWAH HILIR', 'regency_id' => $mempawah->id],
            ['code' => '610402', 'name' => 'MEMPAWAH TIMUR', 'regency_id' => $mempawah->id],
            ['code' => '610403', 'name' => 'SUNGAI PINYUH', 'regency_id' => $mempawah->id],
            ['code' => '610404', 'name' => 'ANJONGAN', 'regency_id' => $mempawah->id],

            // KABUPATEN SANGGAU
            ['code' => '610501', 'name' => 'KAPUAS', 'regency_id' => $sanggau->id],
            ['code' => '610502', 'name' => 'SEKAYAM', 'regency_id' => $sanggau->id],
            ['code' => '610503', 'name' => 'TAYAN HILIR', 'regency_id' => $sanggau->id],
            ['code' => '610504', 'name' => 'TAYAN HULU', 'regency_id' => $sanggau->id],
            ['code' => '610505', 'name' => 'BONTI', 'regency_id' => $sanggau->id],

            // KABUPATEN KETAPANG
            ['code' => '610601', 'name' => 'KETAPANG', 'regency_id' => $ketapang->id],
            ['code' => '610602', 'name' => 'MUARA PAWAN', 'regency_id' => $ketapang->id],
            ['code' => '610603', 'name' => 'MATAN HILIR UTARA', 'regency_id' => $ketapang->id],
            ['code' => '610604', 'name' => 'MARAU', 'regency_id' => $ketapang->id],
            ['code' => '610605', 'name' => 'SANDAI', 'regency_id' => $ketapang->id],
            ['code' => '610606', 'name' => 'BENUA KAYONG', 'regency_id' => $ketapang->id],

            // KABUPATEN SINTANG
            ['code' => '610701', 'name' => 'SINTANG', 'regency_id' => $sintang->id],
            ['code' => '610702', 'name' => 'TEMPUNAK', 'regency_id' => $sintang->id],
            ['code' => '610703', 'name' => 'SEPAUK', 'regency_id' => $sintang->id],
            ['code' => '610704', 'name' => 'KETUNGAU HILIR', 'regency_id' => $sintang->id],
            ['code' => '610705', 'name' => 'KETUNGAU TENGAH', 'regency_id' => $sintang->id],
            ['code' => '610706', 'name' => 'DEDAI', 'regency_id' => $sintang->id],

            // KABUPATEN KAPUAS HULU
            ['code' => '610801', 'name' => 'PUTUSSIBAU SELATAN', 'regency_id' => $kapuas_hulu->id],
            ['code' => '610802', 'name' => 'PUTUSSIBAU UTARA', 'regency_id' => $kapuas_hulu->id],
            ['code' => '610803', 'name' => 'BATU AMPAR', 'regency_id' => $kapuas_hulu->id],
            ['code' => '610804', 'name' => 'EMBALOH HULU', 'regency_id' => $kapuas_hulu->id],

            // KABUPATEN SEKADAU
            ['code' => '610901', 'name' => 'SEKADAU HILIR', 'regency_id' => $sekadau->id],
            ['code' => '610902', 'name' => 'SEKADAU HULU', 'regency_id' => $sekadau->id],
            ['code' => '610903', 'name' => 'NANGA TAMAN', 'regency_id' => $sekadau->id],

            // KABUPATEN MELAWI
            ['code' => '611001', 'name' => 'NANGA PINOH', 'regency_id' => $melawi->id],
            ['code' => '611002', 'name' => 'ELLA HILIR', 'regency_id' => $melawi->id],
            ['code' => '611003', 'name' => 'BELIMBING', 'regency_id' => $melawi->id],
            ['code' => '611004', 'name' => 'PINOH SELATAN', 'regency_id' => $melawi->id],

            // KABUPATEN KAYONG UTARA
            ['code' => '611101', 'name' => 'SUKADANA', 'regency_id' => $kayong_utara->id],
            ['code' => '611102', 'name' => 'SIMPANG HILIR', 'regency_id' => $kayong_utara->id],
            ['code' => '611103', 'name' => 'TELUK BATANG', 'regency_id' => $kayong_utara->id],
            ['code' => '611104', 'name' => 'SEPONTI', 'regency_id' => $kayong_utara->id],

            // KABUPATEN KUBU RAYA
            ['code' => '611201', 'name' => 'SUNGAI RAYA', 'regency_id' => $kubu_raya->id],
            ['code' => '611202', 'name' => 'SUNGAI KAKAP', 'regency_id' => $kubu_raya->id],
            ['code' => '611203', 'name' => 'KUBU', 'regency_id' => $kubu_raya->id],
            ['code' => '611204', 'name' => 'TELUK PAKEDAI', 'regency_id' => $kubu_raya->id],
            ['code' => '611205', 'name' => 'BATU AMPAR', 'regency_id' => $kubu_raya->id],
        ];

        District::insert($districts);
    }

    private function seedVillages()
    {
        // ✅ Gunakan dynamic district ID untuk villages - Fokus Kalimantan Barat
        $pontianak_kota = District::where('code', '617101')->first();
        $pontianak_selatan = District::where('code', '617102')->first();
        $singkawang_barat = District::where('code', '617201')->first();
        $sambas = District::where('code', '610101')->first();
        $bengkayang = District::where('code', '610201')->first();
        $ngabang = District::where('code', '610301')->first();
        $mempawah_hilir = District::where('code', '610401')->first();
        $kapuas = District::where('code', '610501')->first();
        $ketapang = District::where('code', '610601')->first();
        $sintang = District::where('code', '610701')->first();
        $putussibau_selatan = District::where('code', '610801')->first();
        $sekadau_hilir = District::where('code', '610901')->first();
        $nanga_pinoh = District::where('code', '611001')->first();
        $sukadana = District::where('code', '611101')->first();
        $sungai_raya = District::where('code', '611201')->first();

        $villages = [
            // PONTIANAK KOTA
            ['code' => '6171011001', 'name' => 'BENUA MELAYU DARAT', 'district_id' => $pontianak_kota->id],
            ['code' => '6171011002', 'name' => 'BENUA MELAYU LAUT', 'district_id' => $pontianak_kota->id],
            ['code' => '6171011003', 'name' => 'DALAM BUGIS', 'district_id' => $pontianak_kota->id],
            ['code' => '6171011004', 'name' => 'TAMBELAN SAMPIT', 'district_id' => $pontianak_kota->id],
            ['code' => '6171011005', 'name' => 'SUNGAI BANGKONG', 'district_id' => $pontianak_kota->id],

            // PONTIANAK SELATAN
            ['code' => '6171021001', 'name' => 'AKCAYA', 'district_id' => $pontianak_selatan->id],
            ['code' => '6171021002', 'name' => 'KEBANGKITAN', 'district_id' => $pontianak_selatan->id],
            ['code' => '6171021003', 'name' => 'PARIT MAYOR', 'district_id' => $pontianak_selatan->id],
            ['code' => '6171021004', 'name' => 'SUNGAI JAWI DALAM', 'district_id' => $pontianak_selatan->id],
            ['code' => '6171021005', 'name' => 'SUNGAI JAWI LUAR', 'district_id' => $pontianak_selatan->id],

            // SINGKAWANG BARAT
            ['code' => '6172011001', 'name' => 'PASIRAN', 'district_id' => $singkawang_barat->id],
            ['code' => '6172011002', 'name' => 'SAGATANI', 'district_id' => $singkawang_barat->id],
            ['code' => '6172011003', 'name' => 'KUALA', 'district_id' => $singkawang_barat->id],
            ['code' => '6172011004', 'name' => 'SETAPUK BESAR', 'district_id' => $singkawang_barat->id],
            ['code' => '6172011005', 'name' => 'SETAPUK KECIL', 'district_id' => $singkawang_barat->id],

            // SAMBAS
            ['code' => '6101011001', 'name' => 'SAMBAS KOTA', 'district_id' => $sambas->id],
            ['code' => '6101011002', 'name' => 'LUMBANG', 'district_id' => $sambas->id],
            ['code' => '6101011003', 'name' => 'DURIAN', 'district_id' => $sambas->id],
            ['code' => '6101011004', 'name' => 'SEMPALAI', 'district_id' => $sambas->id],
            ['code' => '6101011005', 'name' => 'JAGUR', 'district_id' => $sambas->id],

            // BENGKAYANG
            ['code' => '6102011001', 'name' => 'BUMI EMAS', 'district_id' => $bengkayang->id],
            ['code' => '6102011002', 'name' => 'BENGKAYANG', 'district_id' => $bengkayang->id],
            ['code' => '6102011003', 'name' => 'PAAL', 'district_id' => $bengkayang->id],
            ['code' => '6102011004', 'name' => 'SEBANGKAU', 'district_id' => $bengkayang->id],
            ['code' => '6102011005', 'name' => 'TIRTA KENCANA', 'district_id' => $bengkayang->id],

            // NGABANG (LANDAK)
            ['code' => '6103011001', 'name' => 'NGABANG', 'district_id' => $ngabang->id],
            ['code' => '6103011002', 'name' => 'HILIR KANTOR', 'district_id' => $ngabang->id],
            ['code' => '6103011003', 'name' => 'BATU BESAR', 'district_id' => $ngabang->id],
            ['code' => '6103011004', 'name' => 'SUNGAI ULUK', 'district_id' => $ngabang->id],

            // MEMPAWAH HILIR
            ['code' => '6104011001', 'name' => 'MEMPAWAH HILIR', 'district_id' => $mempawah_hilir->id],
            ['code' => '6104011002', 'name' => 'PASIR', 'district_id' => $mempawah_hilir->id],
            ['code' => '6104011003', 'name' => 'SIANTAN', 'district_id' => $mempawah_hilir->id],
            ['code' => '6104011004', 'name' => 'JUNGKAT', 'district_id' => $mempawah_hilir->id],

            // KAPUAS (SANGGAU)
            ['code' => '6105011001', 'name' => 'KAPUAS', 'district_id' => $kapuas->id],
            ['code' => '6105011002', 'name' => 'BATU PATAH', 'district_id' => $kapuas->id],
            ['code' => '6105011003', 'name' => 'SUNGAI KELIK', 'district_id' => $kapuas->id],
            ['code' => '6105011004', 'name' => 'TANJUNG SEKAYAM', 'district_id' => $kapuas->id],

            // KETAPANG
            ['code' => '6106011001', 'name' => 'DELTA PAWAN', 'district_id' => $ketapang->id],
            ['code' => '6106011002', 'name' => 'MULIA BARU', 'district_id' => $ketapang->id],
            ['code' => '6106011003', 'name' => 'SUKAHARJA', 'district_id' => $ketapang->id],
            ['code' => '6106011004', 'name' => 'SAMPIT', 'district_id' => $ketapang->id],

            // SINTANG
            ['code' => '6107011001', 'name' => 'SINTANG', 'district_id' => $sintang->id],
            ['code' => '6107011002', 'name' => 'KAPUAS KANAN HILIR', 'district_id' => $sintang->id],
            ['code' => '6107011003', 'name' => 'KAPUAS KANAN HULU', 'district_id' => $sintang->id],
            ['code' => '6107011004', 'name' => 'TANJUNG PURI', 'district_id' => $sintang->id],

            // PUTUSSIBAU SELATAN (KAPUAS HULU)
            ['code' => '6108011001', 'name' => 'PUTUSSIBAU SELATAN', 'district_id' => $putussibau_selatan->id],
            ['code' => '6108011002', 'name' => 'SUHAID', 'district_id' => $putussibau_selatan->id],
            ['code' => '6108011003', 'name' => 'PULAU MANAK', 'district_id' => $putussibau_selatan->id],

            // SEKADAU HILIR
            ['code' => '6109011001', 'name' => 'SEKADAU HILIR', 'district_id' => $sekadau_hilir->id],
            ['code' => '6109011002', 'name' => 'TAPANG PULAU', 'district_id' => $sekadau_hilir->id],
            ['code' => '6109011003', 'name' => 'BELITANG HILIR', 'district_id' => $sekadau_hilir->id],

            // NANGA PINOH (MELAWI)
            ['code' => '6110011001', 'name' => 'NANGA PINOH', 'district_id' => $nanga_pinoh->id],
            ['code' => '6110011002', 'name' => 'ELLA HILIR', 'district_id' => $nanga_pinoh->id],
            ['code' => '6110011003', 'name' => 'SOKAN', 'district_id' => $nanga_pinoh->id],

            // SUKADANA (KAYONG UTARA)
            ['code' => '6111011001', 'name' => 'SUKADANA', 'district_id' => $sukadana->id],
            ['code' => '6111011002', 'name' => 'PULAU MAYA', 'district_id' => $sukadana->id],
            ['code' => '6111011003', 'name' => 'HARAPAN', 'district_id' => $sukadana->id],

            // SUNGAI RAYA (KUBU RAYA)
            ['code' => '6112011001', 'name' => 'SUNGAI RAYA', 'district_id' => $sungai_raya->id],
            ['code' => '6112011002', 'name' => 'LIMBUNG', 'district_id' => $sungai_raya->id],
            ['code' => '6112011003', 'name' => 'KUALA MANDOR B', 'district_id' => $sungai_raya->id],
            ['code' => '6112011004', 'name' => 'SUNGAI RAYA DALAM', 'district_id' => $sungai_raya->id],
        ];

        Village::insert($villages);
    }
}
