<?php

namespace Database\Seeders;

use App\Models\Pekerjaan;
use Illuminate\Database\Seeder;

class PekerjaanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $pekerjaan = [
            ['nama_pekerjaan' => 'pekerjaan 1', 'gaji_per_pekerjaan' => 1000, 'deskripsi_pekerjaan' => ''],
            ['nama_pekerjaan' => 'pekerjaan 2', 'gaji_per_pekerjaan' => 2000, 'deskripsi_pekerjaan' => ''],
            ['nama_pekerjaan' => 'pekerjaan 3', 'gaji_per_pekerjaan' => 3000, 'deskripsi_pekerjaan' => ''],
        ];

        foreach ($pekerjaan as $data) {
            Pekerjaan::firstOrCreate(
                ['nama_pekerjaan' => $data['nama_pekerjaan']],
                [
                    'gaji_per_pekerjaan' => $data['gaji_per_pekerjaan'],
                    'deskripsi_pekerjaan' => $data['deskripsi_pekerjaan'],
                ]
            );
        }
    }
}
