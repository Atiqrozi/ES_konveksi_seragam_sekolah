<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\UkuranProduk;
use App\Models\BiayaProduk;
use App\Models\Produk;

class SyncHargaFromBiayaProduk extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ukuran-produk:sync-from-biaya-produk';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync harga_produk_1 dari biaya komponen di BiayaProduk ke UkuranProduk, dan hitung harga_produk_2,3,4';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Memulai sinkronisasi harga dari BiayaProduk ke UkuranProduk...');
        
        // Ambil semua produk yang punya BiayaProduk
        $produks = Produk::with(['biayaProduk', 'produkKomponens'])->whereHas('biayaProduk')->get();
        
        if ($produks->isEmpty()) {
            $this->warn('Tidak ada produk dengan BiayaProduk yang ditemukan.');
            return;
        }
        
        $updated = 0;
        $created = 0;
        
        foreach ($produks as $produk) {
            $this->info("Processing produk: {$produk->nama_produk}");
            
            // Definisi ukuran dan multiplier
            $ukuranMultipliers = [
                'S' => 1.0,
                'M' => 1.3, 
                'L' => 1.6,
                'XL' => 1.9,
                'XXL' => 2.2,
                'JUMBO' => 2.5
            ];
            
            foreach ($ukuranMultipliers as $ukuran => $multiplier) {
                // Hitung harga berdasarkan komponen untuk ukuran ini
                $hargaKomponen = $produk->getTotalBiayaForUkuran($ukuran);
                
                if ($hargaKomponen > 0) {
                    // Cari atau buat UkuranProduk
                    $ukuranProduk = UkuranProduk::firstOrCreate(
                        [
                            'produk_id' => $produk->id,
                            'ukuran' => $ukuran
                        ],
                        [
                            'stok' => 100 // default stock
                        ]
                    );
                    
                    $wasNew = $ukuranProduk->wasRecentlyCreated;
                    
                    // Update harga
                    $ukuranProduk->update([
                        'harga_produk_1' => $hargaKomponen,           // Harga asli dari komponen
                        'harga_produk_2' => $hargaKomponen * 1.10,   // +10%
                        'harga_produk_3' => $hargaKomponen * 1.20,   // +20%
                        'harga_produk_4' => $hargaKomponen * 1.30,   // +30%
                    ]);
                    
                    if ($wasNew) {
                        $created++;
                        $this->line("  ✓ Created ukuran: {$ukuran}");
                    } else {
                        $updated++;
                        $this->line("  ✓ Updated ukuran: {$ukuran}");
                    }
                    
                    $this->line("    Harga 1: Rp " . number_format($ukuranProduk->harga_produk_1, 0, ',', '.'));
                    $this->line("    Harga 2: Rp " . number_format($ukuranProduk->harga_produk_2, 0, ',', '.'));
                    $this->line("    Harga 3: Rp " . number_format($ukuranProduk->harga_produk_3, 0, ',', '.'));
                    $this->line("    Harga 4: Rp " . number_format($ukuranProduk->harga_produk_4, 0, ',', '.'));
                } else {
                    $this->warn("  ! Ukuran {$ukuran} tidak ada komponen atau harga 0");
                }
            }
            
            $this->line('');
        }
        
        $this->info("Selesai! Total: {$updated} updated, {$created} created.");
        $this->line('Harga_produk_1 sekarang berdasarkan perhitungan komponen dari BiayaProduk.');
        $this->line('Harga_produk_2 = harga_produk_1 + 10%');
        $this->line('Harga_produk_3 = harga_produk_1 + 20%');  
        $this->line('Harga_produk_4 = harga_produk_1 + 30%');
    }
}
