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

    protected $fillable = ['id_produk', 'ukuran_produk', 'stok_masuk', 'catatan'];

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'id_produk');
    }
}
