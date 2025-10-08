<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use App\Models\Scopes\Searchable;
use Spatie\Permission\Traits\HasRoles;
use Laravel\Jetstream\HasProfilePhoto;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasRoles;
    use Notifiable;
    use HasFactory;
    use Searchable;
    use HasApiTokens;
    use HasProfilePhoto;

    protected $fillable = [
        'nama',
        'email',
        'password',
        'alamat',
        'no_telepon',
        'jenis_kelamin',
        'tanggal_lahir',
        'tagihan',
    ];

    protected $searchableFields = [
        'nama',
        'email',
    ];

    protected $hidden = [
        'password'
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
    ];

    public function isSuperAdmin(): bool
    {
        return $this->hasRole('Admin');
    }

    public function kegiatan()
    {
        return $this->hasMany(Kegiatan::class, 'user_id');
    }

    public function GajiPegawai()
    {
        return $this->hasOne(GajiPegawai::class, 'pegawai_id');
    }

    public function PenarikanGaji()
    {
        return $this->hasOne(PenarikanGaji::class, 'pegawai_id');
    }

    public function invoice()
    {
        return $this->hasOne(Invoice::class, 'customer_id');
    }

    public function artikel()
    {
        return $this->hasMany(Artikel::class, 'penulis');
    }

    public function absensi()
    {
        return $this->hasMany(Absensi::class);
    }
}
