<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Log;

class BiayaProduk extends Model
{
    use HasFactory;

    protected $fillable = [
        'produk_id',
        'total_biaya_komponen',
        'keterangan',
        'harga_per_ukuran',
        'harga_s_1', 'harga_s_2', 'harga_s_3', 'harga_s_4',
        'harga_m_1', 'harga_m_2', 'harga_m_3', 'harga_m_4',
        'harga_l_1', 'harga_l_2', 'harga_l_3', 'harga_l_4',
        'harga_xl_1', 'harga_xl_2', 'harga_xl_3', 'harga_xl_4',
        'harga_xxl_1', 'harga_xxl_2', 'harga_xxl_3', 'harga_xxl_4',
        'harga_jumbo_1', 'harga_jumbo_2', 'harga_jumbo_3', 'harga_jumbo_4'
    ];

    protected $casts = [
        'total_biaya_komponen' => 'decimal:2',
        'harga_per_ukuran' => 'array',
        'harga_s_1' => 'decimal:2', 'harga_s_2' => 'decimal:2', 'harga_s_3' => 'decimal:2', 'harga_s_4' => 'decimal:2',
        'harga_m_1' => 'decimal:2', 'harga_m_2' => 'decimal:2', 'harga_m_3' => 'decimal:2', 'harga_m_4' => 'decimal:2',
        'harga_l_1' => 'decimal:2', 'harga_l_2' => 'decimal:2', 'harga_l_3' => 'decimal:2', 'harga_l_4' => 'decimal:2',
        'harga_xl_1' => 'decimal:2', 'harga_xl_2' => 'decimal:2', 'harga_xl_3' => 'decimal:2', 'harga_xl_4' => 'decimal:2',
        'harga_xxl_1' => 'decimal:2', 'harga_xxl_2' => 'decimal:2', 'harga_xxl_3' => 'decimal:2', 'harga_xxl_4' => 'decimal:2',
        'harga_jumbo_1' => 'decimal:2', 'harga_jumbo_2' => 'decimal:2', 'harga_jumbo_3' => 'decimal:2', 'harga_jumbo_4' => 'decimal:2',
    ];

    /**
     * Relationship dengan Produk
     */
    public function produk(): BelongsTo
    {
        return $this->belongsTo(Produk::class);
    }

    /**
     * Update total biaya berdasarkan komponen
     */
    public function updateTotalBiaya()
    {
        // Ambil semua komponen untuk produk ini
        $komponen = $this->produk->produkKomponens;
        
        // Log untuk debugging
        Log::info('BiayaProduk updateTotalBiaya:', [
            'produk_id' => $this->produk_id,
            'komponen_count' => $komponen->count(),
            'komponen_data' => $komponen->toArray()
        ]);
        
        // Hitung total dari semua komponen
        $total = $komponen->sum('total_harga');
        
        Log::info('BiayaProduk calculated total:', [
            'total' => $total,
            'individual_totals' => $komponen->pluck('total_harga')->toArray()
        ]);
        
        $this->update(['total_biaya_komponen' => $total]);
        return $total;
    }

    /**
     * Hitung dan update semua tipe harga untuk semua ukuran
     */
    public function updateAllTipeHarga()
    {
        $ukuranList = ['s', 'm', 'l', 'xl', 'xxl', 'jumbo'];
        
        foreach ($ukuranList as $ukuran) {
            $hargaDasar = $this->produk->getTotalBiayaForUkuran(strtoupper($ukuran));
            
            if ($hargaDasar > 0) {
                // Harga Tipe 1: Harga sesungguhnya dari komponen
                $this->{"harga_{$ukuran}_1"} = $hargaDasar;
                
                // Harga Tipe 2: Harga dasar + 10%
                $this->{"harga_{$ukuran}_2"} = $hargaDasar * 1.10;
                
                // Harga Tipe 3: Harga dasar + 20%
                $this->{"harga_{$ukuran}_3"} = $hargaDasar * 1.20;
                
                // Harga Tipe 4: Harga dasar + 30%
                $this->{"harga_{$ukuran}_4"} = $hargaDasar * 1.30;
            }
        }
        
        $this->save();
        return $this;
    }

    /**
     * Get harga berdasarkan ukuran dan tipe
     */
    public function getHarga($ukuran, $tipe = 1)
    {
        $ukuranLower = strtolower($ukuran);
        $field = "harga_{$ukuranLower}_{$tipe}";
        
        return $this->{$field} ?? 0;
    }

    /**
     * Get semua harga untuk ukuran tertentu
     */
    public function getAllHargaForUkuran($ukuran)
    {
        $ukuranLower = strtolower($ukuran);
        
        return [
            'tipe_1' => $this->{"harga_{$ukuranLower}_1"} ?? 0,
            'tipe_2' => $this->{"harga_{$ukuranLower}_2"} ?? 0,
            'tipe_3' => $this->{"harga_{$ukuranLower}_3"} ?? 0,
            'tipe_4' => $this->{"harga_{$ukuranLower}_4"} ?? 0,
        ];
    }

    /**
     * Get array lengkap harga untuk semua ukuran dan tipe
     */
    public function getAllHargaMatrix()
    {
        $matrix = [];
        $ukuranList = ['S', 'M', 'L', 'XL', 'XXL', 'JUMBO'];
        
        foreach ($ukuranList as $ukuran) {
            $matrix[$ukuran] = $this->getAllHargaForUkuran($ukuran);
        }
        
        return $matrix;
    }
}
