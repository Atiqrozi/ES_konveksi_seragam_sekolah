<?php
namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pelamar extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'id', 
        'nama', 
        'email', 
        'alamat', 
        'no_telepon', 
        'jenis_kelamin',
        'tanggal_lahir', 
        'pendidikan_terakhir', 
        'pengalaman', 
        'foto', 
        'cv',
        'status',
        'weighted_sum_model',
        'mulai_wawancara',
        'selesai_wawancara',
        'posisi_id',
        'tentang_diri',
    ];

    protected $casts = [
        'mulai_wawancara' => 'datetime',
        'selesai_wawancara' => 'datetime',
    ];

    protected $searchableFields = ['nama', 'email', 'alamat'];

    public function wsmPelamar()
    {
        return $this->hasMany(WsmPelamar::class);
    }

    public function posisi_lowongan()
    {
        return $this->belongsTo(PosisiLowongan::class, 'posisi_id');
    }
}
