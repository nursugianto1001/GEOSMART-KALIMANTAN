<?php
// database/seeders/DatabaseSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            IndonesiaLocationSeeder::class,
            AdminAndPetugasSeeder::class,
            SurveyKalimantanBaratSeeder::class,
            MainRoadsSeeder::class,
            PublicFacilitiesSeeder::class,
        ]);
    }
}
