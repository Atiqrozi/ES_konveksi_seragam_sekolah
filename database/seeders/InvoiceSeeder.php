<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Produk;
use App\Models\UkuranProduk;
use App\Models\Invoice;
use App\Models\Pesanan;
use Carbon\Carbon;

class InvoiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sales = User::where('email', 'sales@gmail.com')->first();
        $products = Produk::all();

        // Start with the oldest date and go to the newest
        for ($i = 19; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $created_at = $date->format('Y-m-d H:i:s');

            $invoice = Invoice::create([
                'customer_id' => $sales->id,
                'invoice' => 'INV-' . $date->format('Ymd') . '-' . ($i + 1),
                'sub_total' => rand(1000, 5000),
                'tagihan_sebelumnya' => rand(500, 1500),
                'tagihan_total' => rand(1500, 6000),
                'jumlah_bayar' => rand(1000, 3000),
                'tagihan_sisa' => rand(0, 2000),
                'created_at' => $created_at,
                'updated_at' => $created_at,
            ]);

            foreach ($products as $product) {
                // Ambil ukuran yang tersedia untuk produk ini
                $ukuranProduk = UkuranProduk::where('produk_id', $product->id)->get();
                
                // Skip jika produk tidak memiliki ukuran
                if ($ukuranProduk->isEmpty()) {
                    continue;
                }

                // Pilih ukuran secara acak
                $randomUkuran = $ukuranProduk->random();
                
                Pesanan::create([
                    'invoice_id' => $invoice->id,
                    'produk_id' => $product->id,
                    'ukuran' => $randomUkuran->ukuran,
                    'jumlah_pesanan' => rand(1, 5),
                    'harga' => $randomUkuran->harga_produk_1, // Menggunakan harga dari UkuranProduk
                    'created_at' => $created_at,
                    'updated_at' => $created_at,
                ]);
            }
        }
    }
}
