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
        $admin = Role::findById(1);
        $petugas = Role::findById(2);
        $siswa = Role::findById(3);

        $admin->syncPermissions([
            'home',
            'tabungan.index',
            'tabungan.create',
            'tabungan.store',
            'tabungan.show',
            'tabungan.edit',
            'tabungan.update',
            'tabungan.destroy',
            'tabungan.saldo',
            'tahun.index',
            'tahun.create',
            'tahun.store',
            'tahun.show',
            'tahun.update',
            'tahun.destroy',
            'tagihan.index',
            'tagihan.create',
            'tagihan.store',
            'tagihan.show',
            'tagihan.edit',
            'tagihan.update',
            'tagihan.destroy',
            'jenis-tagihan.index',
            'jenis-tagihan.create',
            'jenis-tagihan.store',
            'jenis-tagihan.show',
            'jenis-tagihan.edit',
            'jenis-tagihan.update',
            'jenis-tagihan.destroy',
            'kelas.index',
            'kelas.create',
            'kelas.store',
            'kelas.show',
            'kelas.edit',
            'kelas.update',
            'kelas.destroy',
            'kelas-siswa.index',
            'kelas-siswa.create',
            'kelas-siswa.store',
            'kelas-siswa.destroy',
            'siswa.index',
            'siswa.create',
            'siswa.store',
            'siswa.show',
            'siswa.edit',
            'siswa.update',
            'siswa.destroy',
            'users.index',
            'users.create',
            'users.store',
            'users.show',
            'users.edit',
            'users.update',
            'users.destroy',
            'transaksi.index',
            'transaksi.create',
            'transaksi.store',
            'transaksi.show',
            'transaksi.edit',
            'transaksi.update',
            'transaksi.destroy',
            'transaksi.download',
        ]);

        $petugas->syncPermissions([
            'home',
            'kelas.index',
            'kelas.show',
            'kelas-siswa.index',
            'tahun.index',
            'tahun.show',
            'jenis-tagihan.index',
            'jenis-tagihan.show',
            'siswa.index',
            'siswa.show',
            'tabungan.index',
            'tabungan.create',
            'tabungan.store',
            'tabungan.show',
            'tabungan.saldo',
            'tagihan.index',
            'tagihan.show',
            'tagihan.create',
            'tagihan.store',
            'transaksi.index',
            'transaksi.show',
            'transaksi.create',
            'transaksi.store',
            'transaksi.download',
        ]);

        $siswa->syncPermissions([
            'home',
            'tabungan.siswa',
            'tagihan.siswa',
            'transaksi.siswa',
        ]);
    }
}
