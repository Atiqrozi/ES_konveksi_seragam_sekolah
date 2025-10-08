<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PosisiLowongan extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = ['nama_posisi', 'deskripsi_posisi'];

    protected $searchableFields = ['nama_posisi'];

    public function pelamar()
    {
        return $this->hasMany(Pelamar::class, 'posisi_id');
    }
}
