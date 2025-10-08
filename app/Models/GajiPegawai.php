<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class GajiPegawai extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = ['pegawai_id', 'total_gaji_yang_bisa_diajukan', 'terhitung_tanggal'];

    public function user()
    {
        return $this->belongsTo(User::class ,'pegawai_id');
    }
}
