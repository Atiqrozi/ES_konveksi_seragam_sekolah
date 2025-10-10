<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Produk extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = ['nama_produk', 'kategori_id', 'deskripsi_produk', 'foto_sampul', 'foto_lain_1', 'foto_lain_2', 'foto_lain_3', 'video'];

    protected $searchableFields = ['nama_produk'];

    public function riwayat_stok_produk()
    {
        return $this->hasMany(RiwayatStokProduk::class, 'id_produk');
    }

    public function pesanan()
    {
        return $this->hasMany(Pesanan::class, 'produk_id');
    }

    public function ukuranProduks()
    {
        return $this->belongsToMany(UkuranProduk::class, 'produk_id');
    }

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }

    public function komponens()
    {
        return $this->belongsToMany(Komponen::class, 'produk_komponens')
                    ->withPivot('ukuran', 'quantity')
                    ->withTimestamps();
    }

    public function produkKomponens()
    {
        return $this->hasMany(ProdukKomponen::class);
    }

    public function biayaProduk()
    {
        return $this->hasOne(BiayaProduk::class);
    }

    /**
     * Hitung harga berdasarkan komponen untuk ukuran tertentu
     */
    public function hitungHargaKomponen($ukuran)
    {
        $totalHarga = $this->produkKomponens()
                          ->with('komponen')
                          ->get()
                          ->sum(function ($produkKomponen) use ($ukuran) {
                              return $produkKomponen->getTotalBiayaForUkuran($ukuran);
                          });

        return $totalHarga;
    }

    /**
     * Get total biaya untuk ukuran tertentu (alias for hitungHargaKomponen)
     */
    public function getTotalBiayaForUkuran($ukuran)
    {
        // Hitung total harga menggunakan relasi produkKomponens
        return $this->produkKomponens()
                    ->where('ukuran', $ukuran)
                    ->with('komponen')
                    ->get()
                    ->sum(function($produkKomponen) use ($ukuran) {
                        return $produkKomponen->getTotalBiayaForUkuran($ukuran);
                    });
    }

    /**
     * Get multiplier berdasarkan ukuran
     */
    public function getUkuranMultiplier($ukuran)
    {
        $multipliers = [
            'S' => 1.0,
            'M' => 1.3,
            'L' => 1.6,
            'XL' => 1.9,
            'XXL' => 2.2,
            'JUMBO' => 2.5
        ];

        return $multipliers[strtoupper($ukuran)] ?? 1.0;
    }

    /**
     * Get harga berdasarkan ukuran dan tipe harga
     */
    public function getHargaByTipe($ukuran, $tipe = 1)
    {
        if (!$this->biayaProduk) {
            return 0;
        }

        return $this->biayaProduk->getHarga($ukuran, $tipe);
    }

    /**
     * Get semua harga untuk produk ini dalam format matrix
     */
    public function getAllHargaMatrix()
    {
        if (!$this->biayaProduk) {
            return [];
        }

        return $this->biayaProduk->getAllHargaMatrix();
    }

    /**
     * Update semua tipe harga untuk produk ini
     */
    public function updateAllTipeHarga()
    {
        if ($this->biayaProduk) {
            return $this->biayaProduk->updateAllTipeHarga();
        }
        
        return null;
    }
}
