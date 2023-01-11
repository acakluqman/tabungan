<?php

namespace Database\Seeders;

use App\Models\Kelas;
use App\Models\Tahun;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class KelasSeeder extends Seeder
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
            ['thn_ajaran' => $tahun->thn_ajaran, 'nama' => '1A'],
            ['thn_ajaran' => $tahun->thn_ajaran, 'nama' => '1B'],
            ['thn_ajaran' => $tahun->thn_ajaran, 'nama' => '2A'],
            ['thn_ajaran' => $tahun->thn_ajaran, 'nama' => '2B'],
            ['thn_ajaran' => $tahun->thn_ajaran, 'nama' => '3A'],
            ['thn_ajaran' => $tahun->thn_ajaran, 'nama' => '3B'],
            ['thn_ajaran' => $tahun->thn_ajaran, 'nama' => '4A'],
            ['thn_ajaran' => $tahun->thn_ajaran, 'nama' => '4B'],
            ['thn_ajaran' => $tahun->thn_ajaran, 'nama' => '5A'],
            ['thn_ajaran' => $tahun->thn_ajaran, 'nama' => '5B'],
            ['thn_ajaran' => $tahun->thn_ajaran, 'nama' => '6A'],
            ['thn_ajaran' => $tahun->thn_ajaran, 'nama' => '6B'],
        ];

        foreach ($data as $row) {
            Kelas::create($row);
        }
    }
}
