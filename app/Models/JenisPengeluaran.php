<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class JenisPengeluaran extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'nama_pengeluaran',
        'keterangan',
    ];

    public function absensi()
    {
        return $this->hasMany(Pengeluaran::class);
    }
}
