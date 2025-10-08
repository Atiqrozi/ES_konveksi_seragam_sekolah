<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Pekerjaan;
use App\Models\Kegiatan;
use Faker\Factory as Faker;
use Carbon\Carbon;

class KegiatanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        $pegawaiUsers = User::role('Pegawai')->get();
        $pekerjaans = Pekerjaan::all();

        foreach ($pegawaiUsers as $user) {
            for ($day = 0; $day < 15; $day++) {
                Kegiatan::create([
                    'user_id' => $user->id,
                    'pekerjaan_id' => $pekerjaans->random()->id,
                    'status_kegiatan' => 'Sudah Ditarik',
                    'jumlah_kegiatan' => $faker->numberBetween(1, 100), // Sesuaikan dengan range yang diinginkan
                    'catatan' => '',
                    'kegiatan_dibuat' => Carbon::now()->subDays(14 - $day), // Setiap hari selama 15 hari terakhir
                ]);
            }
        }
    }
}
