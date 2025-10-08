<?php

namespace Database\Seeders;

use App\Models\Kategori;
use Illuminate\Database\Seeder;

class KategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kategoris = [
            [
                'nama' => 'Kemeja',
                'keterangan' => 'Kategori untuk semua jenis kemeja seragam sekolah',
                'foto' => 'public/kategori/kemeja.png'
            ],
            [
                'nama' => 'Celana',
                'keterangan' => 'Kategori untuk semua jenis celana seragam sekolah',
                'foto' => 'public/kategori/celana.png'
            ],
            [
                'nama' => 'Rok',
                'keterangan' => 'Kategori untuk semua jenis rok seragam sekolah',
                'foto' => 'public/kategori/rok.png'
            ],
            [
                'nama' => 'Pramuka',
                'keterangan' => 'Kategori untuk semua jenis seragam pramuka',
                'foto' => 'public/kategori/pramuka.png'
            ],
            [
                'nama' => 'Seragam Harian',
                'keterangan' => 'Kategori untuk seragam harian sekolah',
                'foto' => 'public/kategori/seragam_harian.png'
            ],
        ];

        foreach ($kategoris as $kategori) {
            Kategori::firstOrCreate(
                ['nama' => $kategori['nama']],
                [
                    'keterangan' => $kategori['keterangan'],
                    'foto' => $kategori['foto'],
                ]
            );
        }
    }
}