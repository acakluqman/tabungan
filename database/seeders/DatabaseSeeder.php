<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            TahunAjaranSeeder::class,
            JenisTagihanSeeder::class,
            AdminSeeder::class,
            PetugasSeeder::class,
            SiswaSeeder::class,
            KelasSeeder::class,
        ]);
    }
}
