<?php

namespace Database\Seeders;

use App\Models\JenisTagihan;
use App\Models\Tahun;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JenisTagihanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tahun = Tahun::where('is_aktif', 1)
            ->first();

        $data = [
            [
                'thn_ajaran' => $tahun->thn_ajaran,
                'nama' => 'SPP Bulanan',
                'jml_tagihan' => 150000
            ],
            [
                'thn_ajaran' => $tahun->thn_ajaran,
                'nama' => 'Uang Kegiatan Tahunan',
                'jml_tagihan' => 25000
            ],
            [
                'thn_ajaran' => $tahun->thn_ajaran,
                'nama' => 'Buku dan Perlengkapan Sekolah',
                'jml_tagihan' => 150000
            ],
        ];

        foreach ($data as $row) {
            JenisTagihan::create($row);
        }
    }
}
