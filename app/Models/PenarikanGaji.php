<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PenarikanGaji extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = ['pegawai_id', 'gaji_yang_diajukan', 'status', 'mulai_tanggal', 'akhir_tanggal', 'gaji_diberikan'];

    public function user()
    {
        return $this->belongsTo(User::class ,'pegawai_id');
    }
}
