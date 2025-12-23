<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StokProduk extends Model
{
    use HasFactory;

    protected $table = 'stok_produk';

    protected $fillable = [
        'produk_id',
        'ukuran_produk',
        'stok_tersedia',
    ];

    protected $casts = [
        'stok_tersedia' => 'integer',
    ];

    // Relationship ke Produk
    public function produk()
    {
        return $this->belongsTo(Produk::class);
    }
}
