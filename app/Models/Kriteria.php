<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Kriteria extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = ['nama', 'bobot'];

    protected $searchableFields = ['nama', 'bobot'];

    public function wsmPelamar()
    {
        return $this->hasMany(WsmPelamar::class);
    }
}
