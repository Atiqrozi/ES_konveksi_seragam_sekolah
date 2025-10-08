<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UkuranProduk extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = ['produk_id', 'ukuran', 'stok', 'harga_produk_1', 'harga_produk_2', 'harga_produk_3', 'harga_produk_4',];

    protected $searchableFields = ['produk_id'];

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'produk_id');
    }
}
