<?php

namespace Database\Seeders;

use App\Models\WaktuOpenLamaran;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

class WaktuOpenLamaranSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        WaktuOpenLamaran::firstOrCreate(
            ['active' => false], // Cek berdasarkan status active
            ['active' => false]  // Jika tidak ada, buat dengan active = false
        );
    }
}
