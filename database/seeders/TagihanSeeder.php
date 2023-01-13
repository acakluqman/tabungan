<?php

namespace Database\Seeders;

use App\Models\Siswa;
use App\Models\Tagihan;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TagihanSeeder extends Seeder
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

        foreach ($siswa as $row) {
            $period = \Carbon\CarbonPeriod::create('2022-07-11', '1 month', '2023-07-10');

            foreach ($period as $key => $dt) {
                if ($key == 0) {
                    Tagihan::create([
                        'id_jenis_tagihan' => 1,
                        'id_siswa' => $row->id_siswa,
                        'tgl_tagihan' => $dt->format("Y-m") . '-01',
                        'tgl_jatuh_tempo' => $dt->format("Y-m") . '-15',
                        'id_status_tagihan' => 1,
                    ]);
                    Tagihan::create([
                        'id_jenis_tagihan' => 2,
                        'id_siswa' => $row->id_siswa,
                        'tgl_tagihan' => $dt->format("Y-m") . '-01',
                        'tgl_jatuh_tempo' => $dt->format("Y-m") . '-15',
                        'id_status_tagihan' => 1,
                    ]);
                    Tagihan::create([
                        'id_jenis_tagihan' => 3,
                        'id_siswa' => $row->id_siswa,
                        'tgl_tagihan' => $dt->format("Y-m") . '-01',
                        'tgl_jatuh_tempo' => $dt->format("Y-m") . '-15',
                        'id_status_tagihan' => 1,
                    ]);
                } else {
                    Tagihan::create([
                        'id_jenis_tagihan' => 1,
                        'id_siswa' => $row->id_siswa,
                        'tgl_tagihan' => $dt->format("Y-m") . '-01',
                        'tgl_jatuh_tempo' => $dt->format("Y-m") . '-15',
                        'id_status_tagihan' => 1,
                    ]);
                }
            }
        }
    }
}
