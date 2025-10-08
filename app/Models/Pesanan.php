<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pesanan extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = ['invoice_id', 'produk_id', 'jumlah_pesanan', 'harga', 'ukuran'];

    protected $searchableFields = ['invoice_id', 'produk_id'];

    // Relationship with Invoice model (one-to-many)
    public function invoice()
    {
        return $this->belongsTo(Invoice::class, 'invoice_id');
    }

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'produk_id');
    }
}
