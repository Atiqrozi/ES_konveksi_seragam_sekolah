<?php

namespace Database\Seeders;

use App\Models\GajiPegawai;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Arr;
use Faker\Factory as Faker;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Menggunakan firstOrCreate untuk menghindari duplikasi
        $admin = User::firstOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'nama' => 'Admin',
                'alamat' => 'abc',
                'no_telepon' => '085782003596',
                'password' => Hash::make('admin'),
                'jenis_kelamin' => Arr::random(['Laki-Laki', 'Perempuan']),
                'tanggal_lahir' => now(),
            ]
        );
        if (!$admin->hasRole('Admin')) {
            $admin->assignRole('Admin');
        }

        $sales = User::firstOrCreate(
            ['email' => 'sales@gmail.com'],
            [
                'nama' => 'Sales',
                'alamat' => 'abc',
                'no_telepon' => '085782003596',
                'password' => Hash::make('sales'),
                'jenis_kelamin' => Arr::random(['Laki-Laki', 'Perempuan']),
                'tanggal_lahir' => now(),
            ]
        );
        if (!$sales->hasRole('Sales')) {
            $sales->assignRole('Sales');
        }

        $pegawai = User::firstOrCreate(
            ['email' => 'pegawai@gmail.com'],
            [
                'nama' => 'Pegawai',
                'alamat' => 'abc',
                'no_telepon' => '085782003596',
                'password' => Hash::make('pegawai'),
                'jenis_kelamin' => Arr::random(['Laki-Laki', 'Perempuan']),
                'tanggal_lahir' => now(),
            ]
        );
        if (!$pegawai->hasRole('Pegawai')) {
            $pegawai->assignRole('Pegawai');
        }
        
        // Cek apakah gaji pegawai sudah ada
        $gaji_pegawai = GajiPegawai::firstOrCreate(
            ['pegawai_id' => $pegawai->id],
            [
                'total_gaji_yang_bisa_diajukan' => 0,
                'terhitung_tanggal' => now(),
            ]
        );

        // $faker = Faker::create();
        // $roles = ['Admin', 'Sales', 'Pegawai'];
        // foreach ($roles as $role) {
        //     for ($i = 0; $i < 3; $i++) {
        //         User::create([
        //             'nama' => $faker->name,
        //             'email' => $faker->unique()->safeEmail,
        //             'password' => Hash::make('password'), // or use bcrypt('password')
        //             'alamat' => $faker->address,
        //             'no_telepon' => $faker->phoneNumber,
        //             'jenis_kelamin' => $faker->randomElement(['Laki-Laki', 'Perempuan']),
        //             'tanggal_lahir' => $faker->date,
        //             'tagihan' => $faker->optional()->randomNumber(),
        //         ])->assignRole($role);
        //     }
        // }
    }
}
