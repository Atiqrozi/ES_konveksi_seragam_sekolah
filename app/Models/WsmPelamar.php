<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class WsmPelamar extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = ['pelamar_id', 'kriteria_id', 'skor'];

    public function pelamar()
    {
        return $this->belongsTo(Pelamar::class ,'pelamar_id');
    }

    public function kriteria()
    {
        return $this->belongsTo(Kriteria::class ,'kriteria_id');
    }
}
