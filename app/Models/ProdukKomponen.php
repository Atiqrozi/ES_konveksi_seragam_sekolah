<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProdukKomponen extends Model
{
    use HasFactory;

    protected $fillable = [
        'produk_id',
        'komponen_id',
        'ukuran',
        'quantity'
    ];

    protected $casts = [
        'quantity' => 'decimal:3',
    ];

    /**
     * Relationship dengan Produk
     */
    public function produk(): BelongsTo
    {
        return $this->belongsTo(Produk::class);
    }

    /**
     * Relationship dengan Komponen
     */
    public function komponen(): BelongsTo
    {
        return $this->belongsTo(Komponen::class);
    }

    /**
     * Hitung total biaya komponen berdasarkan ukuran
     */
    public function getTotalBiayaForUkuran($targetUkuran = null)
    {
        // Jika target ukuran tidak diberikan, gunakan ukuran dari record ini
        $ukuran = $targetUkuran ?? $this->ukuran;
        
        $multiplier = $this->getUkuranMultiplier($ukuran);
        return $this->quantity * $this->komponen->harga * $multiplier;
    }

    /**
     * Get total biaya tanpa multiplier ukuran
     */
    public function getTotalBiayaBase()
    {
        return $this->quantity * $this->komponen->harga;
    }

    /**
     * Get multiplier berdasarkan ukuran
     */
    private function getUkuranMultiplier($ukuran)
    {
        $multipliers = [
            'S' => 1.0,
            'M' => 1.3,
            'L' => 1.6,
            'XL' => 1.9,
            'XXL' => 2.2,
            'JUMBO' => 2.5
        ];

        return $multipliers[strtoupper($ukuran)] ?? 1.0;
    }
}