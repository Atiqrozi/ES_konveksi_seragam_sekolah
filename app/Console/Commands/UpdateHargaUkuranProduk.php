<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\UkuranProduk;

class UpdateHargaUkuranProduk extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ukuran-produk:update-harga';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update harga_produk_2, harga_produk_3, harga_produk_4 berdasarkan harga_produk_1';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Memulai update harga ukuran produk...');
        
        $ukuranProduks = UkuranProduk::where('harga_produk_1', '>', 0)->get();
        
        if ($ukuranProduks->isEmpty()) {
            $this->warn('Tidak ada data ukuran produk dengan harga_produk_1 > 0');
            return;
        }
        
        $updated = 0;
        foreach ($ukuranProduks as $ukuranProduk) {
            $hargaDasar = $ukuranProduk->harga_produk_1;
            
            $ukuranProduk->update([
                'harga_produk_2' => $hargaDasar * 1.10, // +10%
                'harga_produk_3' => $hargaDasar * 1.20, // +20%
                'harga_produk_4' => $hargaDasar * 1.30, // +30%
            ]);
            
            $updated++;
            
            $this->line("✓ Updated produk_id: {$ukuranProduk->produk_id}, ukuran: {$ukuranProduk->ukuran}");
            $this->line("  Harga 1: Rp " . number_format($ukuranProduk->harga_produk_1, 0, ',', '.'));
            $this->line("  Harga 2: Rp " . number_format($ukuranProduk->harga_produk_2, 0, ',', '.'));
            $this->line("  Harga 3: Rp " . number_format($ukuranProduk->harga_produk_3, 0, ',', '.'));
            $this->line("  Harga 4: Rp " . number_format($ukuranProduk->harga_produk_4, 0, ',', '.'));
            $this->line('');
        }
        
        $this->info("Selesai! Total {$updated} ukuran produk berhasil diupdate.");
    }
}
