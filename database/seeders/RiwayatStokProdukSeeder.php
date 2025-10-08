<?php

namespace Database\Seeders;

use App\Models\Produk;
use App\Models\UkuranProduk;
use App\Models\RiwayatStokProduk;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class RiwayatStokProdukSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $produks = Produk::all();
        $days = 15;

        foreach ($produks as $produk) {
            // Ambil ukuran yang tersedia untuk produk ini
            $ukuranProduk = UkuranProduk::where('produk_id', $produk->id)->get();
            
            // Skip jika produk tidak memiliki ukuran
            if ($ukuranProduk->isEmpty()) {
                continue;
            }

            for ($i = 0; $i < $days; $i++) {
                // Pilih ukuran secara acak dari ukuran yang tersedia
                $randomUkuran = $ukuranProduk->random();
                
                RiwayatStokProduk::create([
                    'id_produk' => $produk->id,
                    'ukuran_produk' => $randomUkuran->ukuran,
                    'stok_masuk' => rand(1, 20), // stok masuk bervariasi setiap hari
                    'catatan' => 'Stok masuk hari ke-' . ($i + 1) . ' untuk ukuran ' . $randomUkuran->ukuran,
                    'created_at' => Carbon::now()->subDays($days - $i), // atur tanggal sesuai hari
                    'updated_at' => Carbon::now()->subDays($days - $i),
                ]);
            }
        }
    }
}
