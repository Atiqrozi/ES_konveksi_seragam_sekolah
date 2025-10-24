<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Invoice extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = ['invoice', 'customer_id', 'sub_total', 'tagihan_sebelumnya', 'tagihan_total', 'jumlah_bayar', 'tagihan_sisa'];

    protected $searchableFields = ['invoice'];

    // Relationship with Pesanan model (many-to-one)
    public function pesanan()
    {
        return $this->hasMany(Pesanan::class, 'invoice_id');
    }

    // plural alias for backward compatibility (some controllers use 'pesanans')
    public function pesanans()
    {
        return $this->hasMany(Pesanan::class, 'invoice_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }
}
