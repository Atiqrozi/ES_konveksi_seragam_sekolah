<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\UkuranProduk;
use App\Models\Produk;

class UkuranProdukSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil semua produk yang ada
        $produks = Produk::all();
        
        // Ukuran standar yang akan dibuat untuk setiap produk
        $ukuran_standar = ['S', 'M', 'L', 'XL', 'XXL', 'JUMBO'];
        
        // Harga base untuk setiap jenis produk
        $harga_base = [
            'Celana Kempol Pramuka' => 58000,
            'Celana Merah' => 58000,
            'Kemeja Pramuka Panjang' => 49500,
            'Kemeja Pramuka Pendek' => 43000,
            'Kemeja Pramuka Siaga Panjang' => 49500,
            'Kemeja Pramuka Siaga Pendek' => 43000,
            'Kemeja Pramuka Tali' => 49500,
            'Kemeja Putih Panjang' => 48000,
            'Kemeja Putih Pendek' => 42000,
            'Rok Merah' => 65000,
            'Rok Pramuka' => 65000,
        ];

        foreach ($produks as $produk) {
            $base_price = $harga_base[$produk->nama_produk] ?? 50000; // Default 50000 jika tidak ditemukan
            
            foreach ($ukuran_standar as $index => $ukuran) {
                // Harga bertambah sesuai ukuran
                $harga_increment = $index * 1500; // S=0, M=1500, L=3000, dst
                $harga_final = $base_price + $harga_increment;
                
                UkuranProduk::firstOrCreate(
                    [
                        'produk_id' => $produk->id,
                        'ukuran' => $ukuran,
                    ],
                    [
                        'stok' => 100,
                        'harga_produk_1' => $harga_final,
                        'harga_produk_2' => 0,
                        'harga_produk_3' => 0,
                        'harga_produk_4' => 0,
                    ]
                );
            }
        }
    }
}
