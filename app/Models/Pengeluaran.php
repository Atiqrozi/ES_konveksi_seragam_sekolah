<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pengeluaran extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'jenis_pengeluaran_id',
        'keterangan',
        'jumlah',
        'tanggal'
    ];

    public function jenis_pengeluaran()
    {
        return $this->belongsTo(JenisPengeluaran::class);
    }
}
