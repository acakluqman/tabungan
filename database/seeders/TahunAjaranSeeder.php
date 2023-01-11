<?php

namespace Database\Seeders;

use DateTime;
use App\Models\Tahun;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TahunAjaranSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Tahun::create([
            'thn_ajaran' => 2022,
            'tgl_mulai' => new DateTime('2022-07-11'),
            'tgl_selesai' => new DateTime('2023-07-10'),
            'is_aktif' => true
        ]);
    }
}
