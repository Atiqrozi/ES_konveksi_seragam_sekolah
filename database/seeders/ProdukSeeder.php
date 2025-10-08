<?php

namespace Database\Seeders;

use App\Models\Produk;
use App\Models\Kategori;
use Illuminate\Database\Seeder;

class ProdukSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Ambil kategori yang sudah dibuat
        $kategoriCelana = Kategori::where('nama', 'Celana')->first();
        $kategoriKemeja = Kategori::where('nama', 'Kemeja')->first();
        $kategoriRok = Kategori::where('nama', 'Rok')->first();
        $kategoriPramuka = Kategori::where('nama', 'Pramuka')->first();
        $kategoriSeragamHarian = Kategori::where('nama', 'Seragam Harian')->first();

        $produk = [
            [
                'nama_produk' => 'Celana Kempol Pramuka',
                'kategori_id' => $kategoriPramuka->id,
                'deskripsi_produk' => 'Celana kempol untuk seragam pramuka SD, terbuat dari bahan yang nyaman dan tahan lama, ideal untuk kegiatan pramuka.',
                'foto_sampul' => 'public/produk/CELANA_KEMPOL_PRAMUKA.png'
            ],
            [
                'nama_produk' => 'Celana Merah',
                'kategori_id' => $kategoriCelana->id,
                'deskripsi_produk' => 'Celana merah untuk seragam sekolah SD, dengan desain simpel dan bahan berkualitas untuk kenyamanan sehari-hari.',
                'foto_sampul' => 'public/produk/CELANA_MERAH.png'
            ],
            [
                'nama_produk' => 'Kemeja Pramuka Panjang',
                'kategori_id' => $kategoriPramuka->id,
                'deskripsi_produk' => 'Kemeja pramuka panjang untuk siswa SD, dirancang untuk memberikan kesan profesional dan nyaman selama kegiatan pramuka.',
                'foto_sampul' => 'public/produk/KEMEJA_PRAMUKA_PANJANG.png'
            ],
            [
                'nama_produk' => 'Kemeja Pramuka Pendek',
                'kategori_id' => $kategoriPramuka->id,
                'deskripsi_produk' => 'Kemeja pramuka pendek untuk siswa SD, dengan bahan yang adem dan desain yang cocok untuk cuaca panas.',
                'foto_sampul' => 'public/produk/KEMEJA_PRAMUKA_PENDEK.png'
            ],
            [
                'nama_produk' => 'Kemeja Pramuka Siaga Panjang',
                'kategori_id' => $kategoriPramuka->id,
                'deskripsi_produk' => 'Kemeja pramuka siaga panjang untuk siswa SD, dirancang khusus untuk kegiatan siaga dengan bahan yang nyaman.',
                'foto_sampul' => 'public/produk/KEMEJA_PRAMUKA_SIAGA_PANJANG.png'
            ],
            [
                'nama_produk' => 'Kemeja Pramuka Siaga Pendek',
                'kategori_id' => $kategoriPramuka->id,
                'deskripsi_produk' => 'Kemeja pramuka siaga pendek untuk siswa SD, ideal untuk cuaca panas dan aktivitas di luar ruangan.',
                'foto_sampul' => 'public/produk/KEMEJA_PRAMUKA_SIAGA_PENDEK.png'
            ],
            [
                'nama_produk' => 'Kemeja Pramuka Tali',
                'kategori_id' => $kategoriPramuka->id,
                'deskripsi_produk' => 'Kemeja pramuka dengan detail tali untuk siswa SD, memberikan kesan unik dan elegan pada seragam pramuka.',
                'foto_sampul' => 'public/produk/KEMEJA_PRAMUKA_TALI.png'
            ],
            [
                'nama_produk' => 'Kemeja Putih Panjang',
                'kategori_id' => $kategoriKemeja->id,
                'deskripsi_produk' => 'Kemeja putih panjang untuk seragam sekolah SD, cocok untuk berbagai acara dan kegiatan resmi sekolah.',
                'foto_sampul' => 'public/produk/KEMEJA_PUTIH_PANJANG.png'
            ],
            [
                'nama_produk' => 'Kemeja Putih Pendek',
                'kategori_id' => $kategoriKemeja->id,
                'deskripsi_produk' => 'Kemeja putih pendek untuk seragam sekolah SD, nyaman dan cocok untuk penggunaan sehari-hari di sekolah.',
                'foto_sampul' => 'public/produk/KEMEJA_PUTIH_PENDEK.png'
            ],
            [
                'nama_produk' => 'Rok Merah',
                'kategori_id' => $kategoriRok->id,
                'deskripsi_produk' => 'Rok merah untuk seragam SD, modis dan terbuat dari bahan berkualitas dengan desain yang menarik.',
                'foto_sampul' => 'public/produk/ROK_MERAH.png'
            ],
            [
                'nama_produk' => 'Rok Pramuka',
                'kategori_id' => $kategoriPramuka->id,
                'deskripsi_produk' => 'Rok pramuka untuk siswa SD, dirancang dengan desain praktis dan nyaman untuk kegiatan pramuka.',
                'foto_sampul' => 'public/produk/ROK_PRAMUKA.png'
            ],
        ];

        foreach ($produk as $data) {
            Produk::firstOrCreate(
                ['nama_produk' => $data['nama_produk']],
                [
                    'kategori_id' => $data['kategori_id'],
                    'deskripsi_produk' => $data['deskripsi_produk'],
                    'foto_sampul' => $data['foto_sampul'],
                    'foto_lain_1' => null,
                    'foto_lain_2' => null,
                    'foto_lain_3' => null,
                    'video' => null,
                ]
            );
        }
    }
}
