<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pekerjaan extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = ['nama_pekerjaan', 'gaji_per_pekerjaan', 'deskripsi_pekerjaan'];

    protected $searchableFields = ['nama_pekerjaan', 'gaji_per_pekerjaan'];

    public function kegiatan()
    {
        return $this->hasOne(Kegiatan::class, 'pekerjaan_id');
    }
}
