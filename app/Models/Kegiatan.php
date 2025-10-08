<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Kegiatan extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = ['pekerjaan_id', 'user_id', 'catatan', 'status_kegiatan', 'jumlah_kegiatan', 'kegiatan_dibuat'];

    protected $searchableFields = ['pekerjaan_id', 'user_id'];

    public function pekerjaan()
    {
        return $this->belongsTo(Pekerjaan::class, 'pekerjaan_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
