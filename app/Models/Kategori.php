<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Kategori extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = ['nama', 'keterangan', 'foto'];

    protected $searchableFields = ['nama', 'keterangan'];

    public function produk()
    {
        return $this->hasMany(Produk::class, 'kategori_id');
    }
}
