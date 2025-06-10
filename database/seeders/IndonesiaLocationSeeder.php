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
        
        $this->command->info('Kalimantan location seeding completed!');
    }

    private function seedProvinces()
    {
        $provinces = [
            ['code' => '61', 'name' => 'KALIMANTAN BARAT'],
            ['code' => '62', 'name' => 'KALIMANTAN TENGAH'],
            ['code' => '63', 'name' => 'KALIMANTAN SELATAN'],
            ['code' => '64', 'name' => 'KALIMANTAN TIMUR'],
            ['code' => '65', 'name' => 'KALIMANTAN UTARA'],
        ];

        Province::insert($provinces);
    }

    private function seedRegencies()
    {
        // ✅ Gunakan dynamic province ID
        $kalbar = Province::where('code', '61')->first();
        $kalteng = Province::where('code', '62')->first();
        $kalsel = Province::where('code', '63')->first();
        $kaltim = Province::where('code', '64')->first();
        $kaltara = Province::where('code', '65')->first();

        $regencies = [
            // KALIMANTAN BARAT
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

            // KALIMANTAN TENGAH
            ['code' => '6201', 'name' => 'KABUPATEN KOTAWARINGIN BARAT', 'province_id' => $kalteng->id],
            ['code' => '6202', 'name' => 'KABUPATEN KOTAWARINGIN TIMUR', 'province_id' => $kalteng->id],
            ['code' => '6203', 'name' => 'KABUPATEN KAPUAS', 'province_id' => $kalteng->id],
            ['code' => '6204', 'name' => 'KABUPATEN BARITO SELATAN', 'province_id' => $kalteng->id],
            ['code' => '6205', 'name' => 'KABUPATEN BARITO UTARA', 'province_id' => $kalteng->id],
            ['code' => '6206', 'name' => 'KABUPATEN SUKAMARA', 'province_id' => $kalteng->id],
            ['code' => '6207', 'name' => 'KABUPATEN LAMANDAU', 'province_id' => $kalteng->id],
            ['code' => '6208', 'name' => 'KABUPATEN SERUYAN', 'province_id' => $kalteng->id],
            ['code' => '6209', 'name' => 'KABUPATEN KATINGAN', 'province_id' => $kalteng->id],
            ['code' => '6210', 'name' => 'KABUPATEN PULANG PISAU', 'province_id' => $kalteng->id],
            ['code' => '6211', 'name' => 'KABUPATEN GUNUNG MAS', 'province_id' => $kalteng->id],
            ['code' => '6212', 'name' => 'KABUPATEN BARITO TIMUR', 'province_id' => $kalteng->id],
            ['code' => '6213', 'name' => 'KABUPATEN MURUNG RAYA', 'province_id' => $kalteng->id],
            ['code' => '6271', 'name' => 'KOTA PALANGKA RAYA', 'province_id' => $kalteng->id],

            // KALIMANTAN SELATAN
            ['code' => '6301', 'name' => 'KABUPATEN TANAH LAUT', 'province_id' => $kalsel->id],
            ['code' => '6302', 'name' => 'KABUPATEN KOTABARU', 'province_id' => $kalsel->id],
            ['code' => '6303', 'name' => 'KABUPATEN BANJAR', 'province_id' => $kalsel->id],
            ['code' => '6304', 'name' => 'KABUPATEN BARITO KUALA', 'province_id' => $kalsel->id],
            ['code' => '6305', 'name' => 'KABUPATEN TAPIN', 'province_id' => $kalsel->id],
            ['code' => '6306', 'name' => 'KABUPATEN HULU SUNGAI SELATAN', 'province_id' => $kalsel->id],
            ['code' => '6307', 'name' => 'KABUPATEN HULU SUNGAI TENGAH', 'province_id' => $kalsel->id],
            ['code' => '6308', 'name' => 'KABUPATEN HULU SUNGAI UTARA', 'province_id' => $kalsel->id],
            ['code' => '6309', 'name' => 'KABUPATEN TABALONG', 'province_id' => $kalsel->id],
            ['code' => '6310', 'name' => 'KABUPATEN TANAH BUMBU', 'province_id' => $kalsel->id],
            ['code' => '6311', 'name' => 'KABUPATEN BALANGAN', 'province_id' => $kalsel->id],
            ['code' => '6371', 'name' => 'KOTA BANJARMASIN', 'province_id' => $kalsel->id],
            ['code' => '6372', 'name' => 'KOTA BANJARBARU', 'province_id' => $kalsel->id],

            // KALIMANTAN TIMUR
            ['code' => '6401', 'name' => 'KABUPATEN PASER', 'province_id' => $kaltim->id],
            ['code' => '6402', 'name' => 'KABUPATEN KUTAI BARAT', 'province_id' => $kaltim->id],
            ['code' => '6403', 'name' => 'KABUPATEN KUTAI KARTANEGARA', 'province_id' => $kaltim->id],
            ['code' => '6404', 'name' => 'KABUPATEN KUTAI TIMUR', 'province_id' => $kaltim->id],
            ['code' => '6405', 'name' => 'KABUPATEN BERAU', 'province_id' => $kaltim->id],
            ['code' => '6409', 'name' => 'KABUPATEN PENAJAM PASER UTARA', 'province_id' => $kaltim->id],
            ['code' => '6411', 'name' => 'KABUPATEN MAHAKAM ULU', 'province_id' => $kaltim->id],
            ['code' => '6471', 'name' => 'KOTA BALIKPAPAN', 'province_id' => $kaltim->id],
            ['code' => '6472', 'name' => 'KOTA SAMARINDA', 'province_id' => $kaltim->id],
            ['code' => '6474', 'name' => 'KOTA BONTANG', 'province_id' => $kaltim->id],

            // KALIMANTAN UTARA
            ['code' => '6501', 'name' => 'KABUPATEN MALINAU', 'province_id' => $kaltara->id],
            ['code' => '6502', 'name' => 'KABUPATEN BULUNGAN', 'province_id' => $kaltara->id],
            ['code' => '6503', 'name' => 'KABUPATEN TANA TIDUNG', 'province_id' => $kaltara->id],
            ['code' => '6504', 'name' => 'KABUPATEN NUNUKAN', 'province_id' => $kaltara->id],
            ['code' => '6571', 'name' => 'KOTA TARAKAN', 'province_id' => $kaltara->id],
        ];

        Regency::insert($regencies);
    }

    private function seedDistricts()
    {
        // ✅ Gunakan dynamic regency ID
        $pontianak = Regency::where('code', '6171')->first();
        $singkawang = Regency::where('code', '6172')->first();
        $sambas = Regency::where('code', '6101')->first();
        $bengkayang = Regency::where('code', '6102')->first();
        $ketapang = Regency::where('code', '6106')->first();
        $sintang = Regency::where('code', '6107')->first();
        
        $palangkaraya = Regency::where('code', '6271')->first();
        $kotawaringinbarat = Regency::where('code', '6201')->first();
        $kotawaringintimur = Regency::where('code', '6202')->first();
        
        $banjarmasin = Regency::where('code', '6371')->first();
        $banjarbaru = Regency::where('code', '6372')->first();
        $banjar = Regency::where('code', '6303')->first();
        $tanah_laut = Regency::where('code', '6301')->first();
        
        $samarinda = Regency::where('code', '6472')->first();
        $balikpapan = Regency::where('code', '6471')->first();
        $bontang = Regency::where('code', '6474')->first();
        $kutai_kartanegara = Regency::where('code', '6403')->first();
        $kutai_timur = Regency::where('code', '6404')->first();
        $berau = Regency::where('code', '6405')->first();
        
        $tarakan = Regency::where('code', '6571')->first();
        $malinau = Regency::where('code', '6501')->first();
        $bulungan = Regency::where('code', '6502')->first();
        $nunukan = Regency::where('code', '6504')->first();

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

            // KABUPATEN BENGKAYANG
            ['code' => '610201', 'name' => 'BENGKAYANG', 'regency_id' => $bengkayang->id],
            ['code' => '610202', 'name' => 'SAMALANTAN', 'regency_id' => $bengkayang->id],
            ['code' => '610203', 'name' => 'SANGGAU LEDO', 'regency_id' => $bengkayang->id],
            ['code' => '610204', 'name' => 'JAGOI BABANG', 'regency_id' => $bengkayang->id],
            ['code' => '610205', 'name' => 'SELUAS', 'regency_id' => $bengkayang->id],

            // KABUPATEN KETAPANG
            ['code' => '610601', 'name' => 'KETAPANG', 'regency_id' => $ketapang->id],
            ['code' => '610602', 'name' => 'MUARA PAWAN', 'regency_id' => $ketapang->id],
            ['code' => '610603', 'name' => 'MATAN HILIR UTARA', 'regency_id' => $ketapang->id],
            ['code' => '610604', 'name' => 'MARAU', 'regency_id' => $ketapang->id],
            ['code' => '610605', 'name' => 'SANDAI', 'regency_id' => $ketapang->id],

            // KABUPATEN SINTANG
            ['code' => '610701', 'name' => 'SINTANG', 'regency_id' => $sintang->id],
            ['code' => '610702', 'name' => 'TEMPUNAK', 'regency_id' => $sintang->id],
            ['code' => '610703', 'name' => 'SEPAUK', 'regency_id' => $sintang->id],
            ['code' => '610704', 'name' => 'KETUNGAU HILIR', 'regency_id' => $sintang->id],
            ['code' => '610705', 'name' => 'KETUNGAU TENGAH', 'regency_id' => $sintang->id],

            // KOTA PALANGKA RAYA
            ['code' => '627101', 'name' => 'PAHANDUT', 'regency_id' => $palangkaraya->id],
            ['code' => '627102', 'name' => 'SABANGAU', 'regency_id' => $palangkaraya->id],
            ['code' => '627103', 'name' => 'JEKAN RAYA', 'regency_id' => $palangkaraya->id],
            ['code' => '627104', 'name' => 'BUKIT BATU', 'regency_id' => $palangkaraya->id],
            ['code' => '627105', 'name' => 'RAKUMPIT', 'regency_id' => $palangkaraya->id],

            // KABUPATEN KOTAWARINGIN BARAT
            ['code' => '620101', 'name' => 'PANGKALAN BUN', 'regency_id' => $kotawaringinbarat->id],
            ['code' => '620102', 'name' => 'ARUT SELATAN', 'regency_id' => $kotawaringinbarat->id],
            ['code' => '620103', 'name' => 'KUMAI', 'regency_id' => $kotawaringinbarat->id],
            ['code' => '620104', 'name' => 'ARUT UTARA', 'regency_id' => $kotawaringinbarat->id],

            // KABUPATEN KOTAWARINGIN TIMUR
            ['code' => '620201', 'name' => 'SAMPIT', 'regency_id' => $kotawaringintimur->id],
            ['code' => '620202', 'name' => 'SERUYAN HILIR', 'regency_id' => $kotawaringintimur->id],
            ['code' => '620203', 'name' => 'MENTAYA HILIR SELATAN', 'regency_id' => $kotawaringintimur->id],
            ['code' => '620204', 'name' => 'MENTAYA HILIR UTARA', 'regency_id' => $kotawaringintimur->id],

            // KOTA BANJARMASIN
            ['code' => '637101', 'name' => 'BANJARMASIN SELATAN', 'regency_id' => $banjarmasin->id],
            ['code' => '637102', 'name' => 'BANJARMASIN TIMUR', 'regency_id' => $banjarmasin->id],
            ['code' => '637103', 'name' => 'BANJARMASIN BARAT', 'regency_id' => $banjarmasin->id],
            ['code' => '637104', 'name' => 'BANJARMASIN TENGAH', 'regency_id' => $banjarmasin->id],
            ['code' => '637105', 'name' => 'BANJARMASIN UTARA', 'regency_id' => $banjarmasin->id],

            // KOTA BANJARBARU
            ['code' => '637201', 'name' => 'BANJARBARU SELATAN', 'regency_id' => $banjarbaru->id],
            ['code' => '637202', 'name' => 'BANJARBARU UTARA', 'regency_id' => $banjarbaru->id],
            ['code' => '637203', 'name' => 'CEMPAKA', 'regency_id' => $banjarbaru->id],
            ['code' => '637204', 'name' => 'LANDASAN ULIN', 'regency_id' => $banjarbaru->id],
            ['code' => '637205', 'name' => 'LIANG ANGGANG', 'regency_id' => $banjarbaru->id],

            // KABUPATEN BANJAR
            ['code' => '630301', 'name' => 'ALUH-ALUH', 'regency_id' => $banjar->id],
            ['code' => '630302', 'name' => 'ALALAK', 'regency_id' => $banjar->id],
            ['code' => '630303', 'name' => 'GAMBUT', 'regency_id' => $banjar->id],
            ['code' => '630304', 'name' => 'KERTAK HANYAR', 'regency_id' => $banjar->id],
            ['code' => '630305', 'name' => 'MARTAPURA', 'regency_id' => $banjar->id],

            // KABUPATEN TANAH LAUT
            ['code' => '630101', 'name' => 'PELAIHARI', 'regency_id' => $tanah_laut->id],
            ['code' => '630102', 'name' => 'KURAU', 'regency_id' => $tanah_laut->id],
            ['code' => '630103', 'name' => 'BATU AMPAR', 'regency_id' => $tanah_laut->id],
            ['code' => '630104', 'name' => 'JORONG', 'regency_id' => $tanah_laut->id],
            ['code' => '630105', 'name' => 'KINTAP', 'regency_id' => $tanah_laut->id],

            // KOTA SAMARINDA
            ['code' => '647201', 'name' => 'SAMARINDA ILIR', 'regency_id' => $samarinda->id],
            ['code' => '647202', 'name' => 'SAMARINDA ULU', 'regency_id' => $samarinda->id],
            ['code' => '647203', 'name' => 'SAMARINDA UTARA', 'regency_id' => $samarinda->id],
            ['code' => '647204', 'name' => 'SAMARINDA SEBERANG', 'regency_id' => $samarinda->id],
            ['code' => '647205', 'name' => 'PALARAN', 'regency_id' => $samarinda->id],
            ['code' => '647206', 'name' => 'SAMBUTAN', 'regency_id' => $samarinda->id],
            ['code' => '647207', 'name' => 'SAMARINDA KOTA', 'regency_id' => $samarinda->id],
            ['code' => '647208', 'name' => 'LOA JANAN ILIR', 'regency_id' => $samarinda->id],
            ['code' => '647209', 'name' => 'SUNGAI KUNJANG', 'regency_id' => $samarinda->id],
            ['code' => '647210', 'name' => 'SUNGAI PINANG', 'regency_id' => $samarinda->id],

            // KOTA BALIKPAPAN
            ['code' => '647101', 'name' => 'BALIKPAPAN TIMUR', 'regency_id' => $balikpapan->id],
            ['code' => '647102', 'name' => 'BALIKPAPAN BARAT', 'regency_id' => $balikpapan->id],
            ['code' => '647103', 'name' => 'BALIKPAPAN TENGAH', 'regency_id' => $balikpapan->id],
            ['code' => '647104', 'name' => 'BALIKPAPAN UTARA', 'regency_id' => $balikpapan->id],
            ['code' => '647105', 'name' => 'BALIKPAPAN SELATAN', 'regency_id' => $balikpapan->id],
            ['code' => '647106', 'name' => 'BALIKPAPAN KOTA', 'regency_id' => $balikpapan->id],

            // KOTA BONTANG
            ['code' => '647401', 'name' => 'BONTANG UTARA', 'regency_id' => $bontang->id],
            ['code' => '647402', 'name' => 'BONTANG SELATAN', 'regency_id' => $bontang->id],
            ['code' => '647403', 'name' => 'BONTANG BARAT', 'regency_id' => $bontang->id],

            // KABUPATEN KUTAI KARTANEGARA
            ['code' => '640301', 'name' => 'SAMBOJA', 'regency_id' => $kutai_kartanegara->id],
            ['code' => '640302', 'name' => 'MUARA JAWA', 'regency_id' => $kutai_kartanegara->id],
            ['code' => '640303', 'name' => 'SANGA-SANGA', 'regency_id' => $kutai_kartanegara->id],
            ['code' => '640304', 'name' => 'TENGGARONG', 'regency_id' => $kutai_kartanegara->id],
            ['code' => '640305', 'name' => 'SEBULU', 'regency_id' => $kutai_kartanegara->id],

            // KABUPATEN KUTAI TIMUR
            ['code' => '640401', 'name' => 'SANGATTA UTARA', 'regency_id' => $kutai_timur->id],
            ['code' => '640402', 'name' => 'SANGATTA SELATAN', 'regency_id' => $kutai_timur->id],
            ['code' => '640403', 'name' => 'BENGALON', 'regency_id' => $kutai_timur->id],
            ['code' => '640404', 'name' => 'TELUK PANDAN', 'regency_id' => $kutai_timur->id],
            ['code' => '640405', 'name' => 'RANTAU PULUNG', 'regency_id' => $kutai_timur->id],

            // KABUPATEN BERAU
            ['code' => '640501', 'name' => 'TANJUNG REDEB', 'regency_id' => $berau->id],
            ['code' => '640502', 'name' => 'GUNUNG TABUR', 'regency_id' => $berau->id],
            ['code' => '640503', 'name' => 'SAMBALIUNG', 'regency_id' => $berau->id],
            ['code' => '640504', 'name' => 'SEGAH', 'regency_id' => $berau->id],
            ['code' => '640505', 'name' => 'KELAY', 'regency_id' => $berau->id],

            // KOTA TARAKAN
            ['code' => '657101', 'name' => 'TARAKAN BARAT', 'regency_id' => $tarakan->id],
            ['code' => '657102', 'name' => 'TARAKAN TENGAH', 'regency_id' => $tarakan->id],
            ['code' => '657103', 'name' => 'TARAKAN TIMUR', 'regency_id' => $tarakan->id],
            ['code' => '657104', 'name' => 'TARAKAN UTARA', 'regency_id' => $tarakan->id],

            // KABUPATEN MALINAU
            ['code' => '650101', 'name' => 'MALINAU KOTA', 'regency_id' => $malinau->id],
            ['code' => '650102', 'name' => 'MALINAU SELATAN', 'regency_id' => $malinau->id],
            ['code' => '650103', 'name' => 'MALINAU UTARA', 'regency_id' => $malinau->id],
            ['code' => '650104', 'name' => 'PUJUNGAN', 'regency_id' => $malinau->id],
            ['code' => '650105', 'name' => 'KAYAN HILIR', 'regency_id' => $malinau->id],

            // KABUPATEN BULUNGAN
            ['code' => '650201', 'name' => 'TANJUNG SELOR', 'regency_id' => $bulungan->id],
            ['code' => '650202', 'name' => 'SEKATAK', 'regency_id' => $bulungan->id],
            ['code' => '650203', 'name' => 'BUNYU', 'regency_id' => $bulungan->id],
            ['code' => '650204', 'name' => 'TANJUNG PALAS', 'regency_id' => $bulungan->id],
            ['code' => '650205', 'name' => 'PESO', 'regency_id' => $bulungan->id],

            // KABUPATEN NUNUKAN
            ['code' => '650401', 'name' => 'NUNUKAN', 'regency_id' => $nunukan->id],
            ['code' => '650402', 'name' => 'SEBUKU', 'regency_id' => $nunukan->id],
            ['code' => '650403', 'name' => 'KRAYAN', 'regency_id' => $nunukan->id],
            ['code' => '650404', 'name' => 'SEBATIK', 'regency_id' => $nunukan->id],
            ['code' => '650405', 'name' => 'LUMBIS', 'regency_id' => $nunukan->id],
        ];

        District::insert($districts);
    }

    private function seedVillages()
    {
        // ✅ Gunakan dynamic district ID untuk villages
        $pontianak_kota = District::where('code', '617101')->first();
        $pontianak_selatan = District::where('code', '617102')->first();
        $singkawang_barat = District::where('code', '617201')->first();
        $sambas = District::where('code', '610101')->first();
        $bengkayang = District::where('code', '610201')->first();
        
        $pahandut = District::where('code', '627101')->first();
        $sabangau = District::where('code', '627102')->first();
        $pangkalan_bun = District::where('code', '620101')->first();
        $sampit = District::where('code', '620201')->first();
        
        $banjarmasin_selatan = District::where('code', '637101')->first();
        $banjarmasin_timur = District::where('code', '637102')->first();
        $banjarbaru_selatan = District::where('code', '637201')->first();
        $martapura = District::where('code', '630305')->first();
        $pelaihari = District::where('code', '630101')->first();
        
        $samarinda_ilir = District::where('code', '647201')->first();
        $samarinda_ulu = District::where('code', '647202')->first();
        $balikpapan_timur = District::where('code', '647101')->first();
        $balikpapan_barat = District::where('code', '647102')->first();
        $bontang_utara = District::where('code', '647401')->first();
        $samboja = District::where('code', '640301')->first();
        $sangatta_utara = District::where('code', '640401')->first();
        $tanjung_redeb = District::where('code', '640501')->first();
        
        $tarakan_barat = District::where('code', '657101')->first();
        $tarakan_tengah = District::where('code', '657102')->first();
        $malinau_kota = District::where('code', '650101')->first();
        $tanjung_selor = District::where('code', '650201')->first();
        $nunukan = District::where('code', '650401')->first();

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

            // PAHANDUT, PALANGKA RAYA
            ['code' => '6271011001', 'name' => 'PAHANDUT', 'district_id' => $pahandut->id],
            ['code' => '6271011002', 'name' => 'PANARUNG', 'district_id' => $pahandut->id],
            ['code' => '6271011003', 'name' => 'TANJUNG PINANG', 'district_id' => $pahandut->id],
            ['code' => '6271011004', 'name' => 'LANGKAI', 'district_id' => $pahandut->id],

            // SABANGAU, PALANGKA RAYA
            ['code' => '6271021001', 'name' => 'SABANGAU', 'district_id' => $sabangau->id],
            ['code' => '6271021002', 'name' => 'KERENG BANGKIRAI', 'district_id' => $sabangau->id],
            ['code' => '6271021003', 'name' => 'DANAU TUNDAI', 'district_id' => $sabangau->id],

            // PANGKALAN BUN
            ['code' => '6201011001', 'name' => 'MENDAWAI', 'district_id' => $pangkalan_bun->id],
            ['code' => '6201011002', 'name' => 'SIDOREJO', 'district_id' => $pangkalan_bun->id],
            ['code' => '6201011003', 'name' => 'FLAMBOYAN', 'district_id' => $pangkalan_bun->id],
            ['code' => '6201011004', 'name' => 'BARU', 'district_id' => $pangkalan_bun->id],

            // SAMPIT
            ['code' => '6202011001', 'name' => 'BAAMANG', 'district_id' => $sampit->id],
            ['code' => '6202011002', 'name' => 'BUNTOK KOTA', 'district_id' => $sampit->id],
            ['code' => '6202011003', 'name' => 'MENTAWA BARU HILIR', 'district_id' => $sampit->id],
            ['code' => '6202011004', 'name' => 'SAMPIT', 'district_id' => $sampit->id],

            // BANJARMASIN SELATAN
            ['code' => '6371011001', 'name' => 'BASIRIH SELATAN', 'district_id' => $banjarmasin_selatan->id],
            ['code' => '6371011002', 'name' => 'KELAYAN BARAT', 'district_id' => $banjarmasin_selatan->id],
            ['code' => '6371011003', 'name' => 'KELAYAN DALAM', 'district_id' => $banjarmasin_selatan->id],
            ['code' => '6371011004', 'name' => 'KELAYAN SELATAN', 'district_id' => $banjarmasin_selatan->id],
            ['code' => '6371011005', 'name' => 'KELAYAN TENGAH', 'district_id' => $banjarmasin_selatan->id],
            ['code' => '6371011006', 'name' => 'KELAYAN TIMUR', 'district_id' => $banjarmasin_selatan->id],
            ['code' => '6371011007', 'name' => 'MANTUIL', 'district_id' => $banjarmasin_selatan->id],
            ['code' => '6371011008', 'name' => 'PEMURUS BARU', 'district_id' => $banjarmasin_selatan->id],
            ['code' => '6371011009', 'name' => 'PEMURUS DALAM', 'district_id' => $banjarmasin_selatan->id],
            ['code' => '6371011010', 'name' => 'TANJUNG PAGAR', 'district_id' => $banjarmasin_selatan->id],

            // BANJARMASIN TIMUR
            ['code' => '6371021001', 'name' => 'KARANG MEKAR', 'district_id' => $banjarmasin_timur->id],
            ['code' => '6371021002', 'name' => 'KEBUN BUNGA', 'district_id' => $banjarmasin_timur->id],
            ['code' => '6371021003', 'name' => 'KURIPAN', 'district_id' => $banjarmasin_timur->id],
            ['code' => '6371021004', 'name' => 'PEKAPURAN RAYA', 'district_id' => $banjarmasin_timur->id],
            ['code' => '6371021005', 'name' => 'PENGAMBANGAN', 'district_id' => $banjarmasin_timur->id],
            ['code' => '6371021006', 'name' => 'SUNGAI BARU', 'district_id' => $banjarmasin_timur->id],
            ['code' => '6371021007', 'name' => 'SUNGAI MESA', 'district_id' => $banjarmasin_timur->id],

            // BANJARBARU SELATAN
            ['code' => '6372011001', 'name' => 'GUNTUNG MANGGIS', 'district_id' => $banjarbaru_selatan->id],
            ['code' => '6372011002', 'name' => 'GUNTUNG PAYUNG', 'district_id' => $banjarbaru_selatan->id],
            ['code' => '6372011003', 'name' => 'KOMET', 'district_id' => $banjarbaru_selatan->id],
            ['code' => '6372011004', 'name' => 'LOKTABAT SELATAN', 'district_id' => $banjarbaru_selatan->id],
            ['code' => '6372011005', 'name' => 'MENTAOS', 'district_id' => $banjarbaru_selatan->id],
            ['code' => '6372011006', 'name' => 'SYAMSUDIN NOOR', 'district_id' => $banjarbaru_selatan->id],

            // MARTAPURA
            ['code' => '6303051001', 'name' => 'JAWA', 'district_id' => $martapura->id],
            ['code' => '6303051002', 'name' => 'KERATON', 'district_id' => $martapura->id],
            ['code' => '6303051003', 'name' => 'MARTAPURA KOTA', 'district_id' => $martapura->id],
            ['code' => '6303051004', 'name' => 'SUNGAI SIPAI', 'district_id' => $martapura->id],
            ['code' => '6303051005', 'name' => 'TAMBAK ANYAR', 'district_id' => $martapura->id],

            // PELAIHARI
            ['code' => '6301011001', 'name' => 'ANGSAU', 'district_id' => $pelaihari->id],
            ['code' => '6301011002', 'name' => 'BATU AMPAR', 'district_id' => $pelaihari->id],
            ['code' => '6301011003', 'name' => 'PELAIHARI', 'district_id' => $pelaihari->id],
            ['code' => '6301011004', 'name' => 'RANGGANG', 'district_id' => $pelaihari->id],
            ['code' => '6301011005', 'name' => 'TAKISUNG', 'district_id' => $pelaihari->id],

            // SAMARINDA ILIR
            ['code' => '6472011001', 'name' => 'SELILI', 'district_id' => $samarinda_ilir->id],
            ['code' => '6472011002', 'name' => 'SUNGAI DAMA', 'district_id' => $samarinda_ilir->id],
            ['code' => '6472011003', 'name' => 'PELITA', 'district_id' => $samarinda_ilir->id],
            ['code' => '6472011004', 'name' => 'TEMINDUNG PERMAI', 'district_id' => $samarinda_ilir->id],
            ['code' => '6472011005', 'name' => 'SIDOMULYO', 'district_id' => $samarinda_ilir->id],

            // SAMARINDA ULU
            ['code' => '6472021001', 'name' => 'AIR HITAM', 'district_id' => $samarinda_ulu->id],
            ['code' => '6472021002', 'name' => 'AIR PUTIH', 'district_id' => $samarinda_ulu->id],
            ['code' => '6472021003', 'name' => 'BUDAYA PAMPANG', 'district_id' => $samarinda_ulu->id],
            ['code' => '6472021004', 'name' => 'GUNUNG KELUA', 'district_id' => $samarinda_ulu->id],
            ['code' => '6472021005', 'name' => 'JAWA', 'district_id' => $samarinda_ulu->id],

            // BALIKPAPAN TIMUR
            ['code' => '6471011001', 'name' => 'LAMARU', 'district_id' => $balikpapan_timur->id],
            ['code' => '6471011002', 'name' => 'MANGGAR', 'district_id' => $balikpapan_timur->id],
            ['code' => '6471011003', 'name' => 'MANGGAR BARU', 'district_id' => $balikpapan_timur->id],
            ['code' => '6471011004', 'name' => 'TERITIP', 'district_id' => $balikpapan_timur->id],

            // BALIKPAPAN BARAT
            ['code' => '6471021001', 'name' => 'BARU ILIR', 'district_id' => $balikpapan_barat->id],
            ['code' => '6471021002', 'name' => 'BARU TENGAH', 'district_id' => $balikpapan_barat->id],
            ['code' => '6471021003', 'name' => 'BARU ULU', 'district_id' => $balikpapan_barat->id],
            ['code' => '6471021004', 'name' => 'GUNUNG BAHAGIA', 'district_id' => $balikpapan_barat->id],

            // BONTANG UTARA
            ['code' => '6474011001', 'name' => 'API-API', 'district_id' => $bontang_utara->id],
            ['code' => '6474011002', 'name' => 'BONTANG KUALA', 'district_id' => $bontang_utara->id],
            ['code' => '6474011003', 'name' => 'GUNTUNG', 'district_id' => $bontang_utara->id],
            ['code' => '6474011004', 'name' => 'KANAAN', 'district_id' => $bontang_utara->id],
            ['code' => '6474011005', 'name' => 'TANJUNG LAUT', 'district_id' => $bontang_utara->id],

            // SAMBOJA
            ['code' => '6403011001', 'name' => 'AMBORAWANG DARAT', 'district_id' => $samboja->id],
            ['code' => '6403011002', 'name' => 'AMBORAWANG LAUT', 'district_id' => $samboja->id],
            ['code' => '6403011003', 'name' => 'HANDIL BAKTI', 'district_id' => $samboja->id],
            ['code' => '6403011004', 'name' => 'KARYA JAYA', 'district_id' => $samboja->id],
            ['code' => '6403011005', 'name' => 'MARGAHAYU', 'district_id' => $samboja->id],
            ['code' => '6403011006', 'name' => 'SAMBOJA', 'district_id' => $samboja->id],
            ['code' => '6403011007', 'name' => 'SAMBOJA KUALA', 'district_id' => $samboja->id],
            ['code' => '6403011008', 'name' => 'WONOSARI', 'district_id' => $samboja->id],

            // SANGATTA UTARA
            ['code' => '6404011001', 'name' => 'BENGALON', 'district_id' => $sangatta_utara->id],
            ['code' => '6404011002', 'name' => 'SANGATTA UTARA', 'district_id' => $sangatta_utara->id],
            ['code' => '6404011003', 'name' => 'SWARGA BARA', 'district_id' => $sangatta_utara->id],
            ['code' => '6404011004', 'name' => 'TELUK DALAM', 'district_id' => $sangatta_utara->id],

            // TANJUNG REDEB
            ['code' => '6405011001', 'name' => 'BUGIS', 'district_id' => $tanjung_redeb->id],
            ['code' => '6405011002', 'name' => 'GAYAM', 'district_id' => $tanjung_redeb->id],
            ['code' => '6405011003', 'name' => 'GUNUNG PANJANG', 'district_id' => $tanjung_redeb->id],
            ['code' => '6405011004', 'name' => 'KARANG AMBUN', 'district_id' => $tanjung_redeb->id],
            ['code' => '6405011005', 'name' => 'TANJUNG REDEB', 'district_id' => $tanjung_redeb->id],

            // TARAKAN BARAT
            ['code' => '6571011001', 'name' => 'KARANG ANYAR', 'district_id' => $tarakan_barat->id],
            ['code' => '6571011002', 'name' => 'KARANG BALIK', 'district_id' => $tarakan_barat->id],
            ['code' => '6571011003', 'name' => 'KARANG HARAPAN', 'district_id' => $tarakan_barat->id],
            ['code' => '6571011004', 'name' => 'KARANG REJO', 'district_id' => $tarakan_barat->id],

            // TARAKAN TENGAH
            ['code' => '6571021001', 'name' => 'KAMPUNG BUGIS', 'district_id' => $tarakan_tengah->id],
            ['code' => '6571021002', 'name' => 'KAMPUNG EMPAT', 'district_id' => $tarakan_tengah->id],
            ['code' => '6571021003', 'name' => 'PAMUSIAN', 'district_id' => $tarakan_tengah->id],
            ['code' => '6571021004', 'name' => 'SELUMIT', 'district_id' => $tarakan_tengah->id],

            // MALINAU KOTA
            ['code' => '6501011001', 'name' => 'SETURAN', 'district_id' => $malinau_kota->id],
            ['code' => '6501011002', 'name' => 'MALINAU KOTA', 'district_id' => $malinau_kota->id],
            ['code' => '6501011003', 'name' => 'MALINAU HILIR', 'district_id' => $malinau_kota->id],
            ['code' => '6501011004', 'name' => 'SESUA', 'district_id' => $malinau_kota->id],

            // TANJUNG SELOR
            ['code' => '6502011001', 'name' => 'TANJUNG SELOR HILIR', 'district_id' => $tanjung_selor->id],
            ['code' => '6502011002', 'name' => 'TANJUNG SELOR HULU', 'district_id' => $tanjung_selor->id],
            ['code' => '6502011003', 'name' => 'APAU PING', 'district_id' => $tanjung_selor->id],
            ['code' => '6502011004', 'name' => 'GUNUNG ANTANG', 'district_id' => $tanjung_selor->id],

            // NUNUKAN
            ['code' => '6504011001', 'name' => 'NUNUKAN SELATAN', 'district_id' => $nunukan->id],
            ['code' => '6504011002', 'name' => 'NUNUKAN UTARA', 'district_id' => $nunukan->id],
            ['code' => '6504011003', 'name' => 'NUNUKAN TIMUR', 'district_id' => $nunukan->id],
            ['code' => '6504011004', 'name' => 'NUNUKAN TENGAH', 'district_id' => $nunukan->id],
            ['code' => '6504011005', 'name' => 'MANSALONG', 'district_id' => $nunukan->id],
        ];

        Village::insert($villages);
    }
}
