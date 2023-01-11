<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Siswa;
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
        $role = Role::create(['name' => 'siswa']);
        $permissions = Permission::pluck('id', 'id')->all();
        $role->syncPermissions($permissions);

        for ($i = 0; $i < 100; $i++) {
            $faker = Faker::create('id_ID');

            $nis = 2190 . sprintf('%02d', $i);
            $nama = $faker->firstName() . ' ' . $faker->lastName();

            $user = new User();
            $user->username = $nis;
            $user->nama = $nama;
            $user->email = $faker->safeEmail();
            $user->password = Hash::make($nis);
            $user->save();

            $user->assignRole([$role->id]);

            $siswa = Siswa::create([
                'nis' => $nis,
                'nama' => $nama,
                'alamat' => $faker->address(),
                'id_user' => $user->id_user
            ]);
        }
    }
}
