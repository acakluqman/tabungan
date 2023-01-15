<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $petugas = Role::findById(2);
        $siswa = Role::findById(3);

        $petugas->syncPermissions([
            'home',
            'kelas.index',
            'kelas.show',
            'jenis-tagihan.index',
            'jenis-tagihan.show',
            'siswa.index',
            'siswa.show',
            'tabungan.index',
            'tabungan.show',
            'tabungan.saldo',
            'tagihan.index',
            'tagihan.show',
            'transaksi.index',
            'transaksi.show',

        ]);

        $siswa->syncPermissions([
            'home',
            'tabungan.index',
            'tabungan.show',
            'tagihan.index',
            'tagihan.show',
            'transaksi.index',
            'transaksi.show',
        ]);
    }
}
