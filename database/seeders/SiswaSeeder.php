<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Kelas;
use App\Models\KelasSiswa;
use App\Models\Siswa;
use App\Models\Tahun;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SiswaSeeder extends Seeder
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

        $role = Role::create(['name' => 'siswa']);
        $permissions = Permission::pluck('id', 'id')->all();
        $role->syncPermissions($permissions);

        foreach ($data as $row) {
            $kelas = Kelas::create($row);

            for ($i = 0; $i < 25; $i++) {
                $faker = Faker::create('id_ID');

                $nis = $faker->numerify('######');
                $gender = $faker->randomElement(['male', 'female']);
                $nama = $faker->firstName($gender) . ' ' . $faker->lastName();

                $user = new User();
                $user->username = $nis;
                $user->nama = $nama;
                $user->email = $nis . '@gmail.com';
                $user->password = Hash::make($nis);
                $user->save();

                $user->assignRole([$role->id]);

                $siswa = Siswa::create([
                    'nis' => $nis,
                    'nama' => $nama,
                    'jk' => $gender == 'male' ? 'L' : 'P',
                    'alamat' => $faker->address(),
                    'id_user' => $user->id_user
                ]);

                $kelassiswa = KelasSiswa::create([
                    'id_kelas' => $kelas->id_kelas,
                    'id_siswa' => $siswa->id_siswa,
                    'thn_ajaran' => $tahun->thn_ajaran,
                ]);
            }
        }
    }
}
