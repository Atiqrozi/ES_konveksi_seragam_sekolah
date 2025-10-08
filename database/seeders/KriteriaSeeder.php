<?php

namespace Database\Seeders;

use App\Models\Kriteria;
use Illuminate\Database\Seeder;

class KriteriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Data kriteria beserta bobot
        $kriteria = [
            ['nama' => 'Pengalaman Kerja', 'bobot' => 0.20],
            ['nama' => 'Pengetahuan Teknis', 'bobot' => 0.20],
            ['nama' => 'Kreativitas', 'bobot' => 0.10],
            ['nama' => 'Kemampuan Komunikasi', 'bobot' => 0.15],
            ['nama' => 'Problem Solving', 'bobot' => 0.15],
            ['nama' => 'Kepatuhan Standar', 'bobot' => 0.05],
            ['nama' => 'Ambisi', 'bobot' => 0.05],
            ['nama' => 'Keterampilan Manajerial', 'bobot' => 0.10],
        ];

        // Masukkan data ke dalam tabel 'kriteria' menggunakan model Kriteria
        foreach ($kriteria as $data) {
            Kriteria::firstOrCreate(
                ['nama' => $data['nama']],
                ['bobot' => $data['bobot']]
            );
        }
    }
}
