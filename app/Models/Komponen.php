<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Komponen extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_komponen',
        'harga'
    ];

    protected $casts = [
        'harga' => 'decimal:2',
    ];

    /**
     * Relationship dengan Produk
     */
    public function produks(): BelongsToMany
    {
        return $this->belongsToMany(Produk::class, 'produk_komponens')
                    ->withPivot('ukuran', 'quantity')
                    ->withTimestamps();
    }

    /**
     * Format harga untuk display
     */
    public function getFormattedHargaAttribute()
    {
        return 'Rp ' . number_format((float) $this->harga, 0, ',', '.');
    }
}