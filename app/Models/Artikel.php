<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Artikel extends Model
{
    use HasFactory;

    protected $fillable = [
        'judul',
        'konten',
        'slug',
        'penulis',
        'cover',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'penulis');
    }

    // Jika ingin menggunakan slug sebagai unique identifier di URL
    public function getRouteKeyName()
    {
        return 'slug';
    }
}
