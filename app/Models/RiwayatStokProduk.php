<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Scopes\Searchable;
use App\Models\Produk;

class RiwayatStokProduk extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'id_produk', 
        'ukuran_produk', 
        'stok_masuk', 
        'stok_keluar', 
        'tipe_transaksi', 
        'user_id',
        'catatan'
    ];

    protected $casts = [
        'tipe_transaksi' => 'string',
    ];

    protected $searchableFields = ['*'];

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'id_produk');
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }
}
