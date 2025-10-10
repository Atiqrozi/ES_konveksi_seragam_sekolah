<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\BiayaProduk;

class UpdateTipeHarga extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'biaya-produk:update-tipe-harga';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update semua tipe harga untuk produk yang sudah ada biaya produknya';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Memulai update tipe harga...');
        
        $biayaProduks = BiayaProduk::with('produk')->get();
        
        if ($biayaProduks->isEmpty()) {
            $this->warn('Tidak ada BiayaProduk yang ditemukan.');
            return;
        }
        
        $updated = 0;
        foreach ($biayaProduks as $biayaProduk) {
            $this->info("Mengupdate tipe harga untuk produk: {$biayaProduk->produk->nama_produk}");
            
            try {
                $biayaProduk->updateAllTipeHarga();
                $updated++;
                
                $this->line("  ✓ Berhasil update - Harga S Tipe 1: Rp " . number_format($biayaProduk->harga_s_1, 0, ',', '.'));
                $this->line("  ✓ Harga S Tipe 2: Rp " . number_format($biayaProduk->harga_s_2, 0, ',', '.'));
                $this->line("  ✓ Harga S Tipe 3: Rp " . number_format($biayaProduk->harga_s_3, 0, ',', '.'));
                $this->line("  ✓ Harga S Tipe 4: Rp " . number_format($biayaProduk->harga_s_4, 0, ',', '.'));
                
            } catch (\Exception $e) {
                $this->error("  ✗ Gagal update: " . $e->getMessage());
            }
            
            $this->line('');
        }
        
        $this->info("Selesai! Total {$updated} BiayaProduk berhasil diupdate.");
    }
}
