<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PosisiLowonganSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $posisiLowongans = [
            [
                'nama_posisi' => 'Software Engineer',
                'deskripsi_posisi' => 'Bertanggung jawab atas pengembangan, pengujian, dan pemeliharaan aplikasi perangkat lunak.',
            ],
            [
                'nama_posisi' => 'UI/UX Designer',
                'deskripsi_posisi' => 'Merancang antarmuka pengguna yang menarik dan pengalaman pengguna yang intuitif.',
            ],
            [
                'nama_posisi' => 'Product Manager',
                'deskripsi_posisi' => 'Mengelola siklus hidup produk dari konsep hingga peluncuran.',
            ],
            [
                'nama_posisi' => 'Data Analyst',
                'deskripsi_posisi' => 'Menganalisis data untuk memberikan wawasan yang dapat digunakan untuk pengambilan keputusan bisnis.',
            ],
            [
                'nama_posisi' => 'HR Manager',
                'deskripsi_posisi' => 'Mengelola fungsi sumber daya manusia, termasuk rekrutmen, pelatihan, dan pengembangan karyawan.',
            ],
        ];

        foreach ($posisiLowongans as $posisi) {
            DB::table('posisi_lowongans')->insertOrIgnore([
                'nama_posisi' => $posisi['nama_posisi'],
                'deskripsi_posisi' => $posisi['deskripsi_posisi'],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}
