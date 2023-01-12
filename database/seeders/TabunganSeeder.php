<?php

namespace Database\Seeders;

use App\Models\Siswa;
use App\Models\Tabungan;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TabunganSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $siswa = Siswa::all();

        $faker = Faker::create('id_ID');

        foreach ($siswa as $s) {
            for ($i = 1; $i <= random_int(1, 5); $i++) {
                if (in_array($i, [1, 2, 3])) {
                    $tipe = 'debit';
                    $nominal = $faker->randomElement([20000, 25000, 35000, 40000, 45000, 50000, 55000, 100000]);
                } else {
                    $tipe = 'kredit';
                    $nominal = $faker->randomElement([2000, 5000]);
                }
                Tabungan::create([
                    'tipe' => $tipe,
                    'id_siswa' => $s->id_siswa,
                    'nominal' => $nominal,
                    'tgl_transaksi' => $faker->dateTimeBetween('2022-07-11', now()),
                    'id_petugas' => 2
                ]);
            }
        }
    }
}
