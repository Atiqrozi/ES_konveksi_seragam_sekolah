<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class PelamarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');
        
        // Ambil semua ID posisi dari tabel posisi_lowongans
        $posisiIds = DB::table('posisi_lowongans')->pluck('id')->toArray();

        foreach (range(1, 25) as $index) {
            DB::table('pelamars')->insert([
                'nama' => $faker->name,
                'email' => $faker->unique()->safeEmail,
                'alamat' => $faker->address,
                'no_telepon' => $faker->phoneNumber,
                'jenis_kelamin' => $faker->randomElement(['Laki-Laki', 'Perempuan']),
                'tanggal_lahir' => $faker->date(),
                'pendidikan_terakhir' => $faker->randomElement(['SMA', 'Diploma', 'Sarjana']),
                'pengalaman' => $faker->sentence,
                'foto' => $faker->imageUrl(640, 480, 'people'),
                'cv' => $faker->url,
                'status' => $faker->randomElement(['Diterima', 'Ditolak', 'Menunggu']),
                'weighted_sum_model' => $faker->randomFloat(2, 1, 5),
                'mulai_wawancara' => $faker->dateTimeBetween('-1 month', 'now'),
                'selesai_wawancara' => $faker->dateTimeBetween('now', '+1 month'),
                'posisi_id' => $faker->randomElement($posisiIds),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
