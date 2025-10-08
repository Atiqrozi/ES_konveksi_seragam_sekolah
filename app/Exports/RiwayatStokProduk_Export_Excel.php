<?php

namespace App\Exports;

use App\Models\RiwayatStokProduk;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class RiwayatStokProduk_Export_Excel implements FromCollection, WithHeadings, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */

    protected $timestamp;

    public function __construct()
    {
        $this->timestamp = now()->format('Y-m-d_H-i-s');
    }

    public function headings(): array
    {
        return [
            'ID',
            'Nama Produk',
            'Ukuran Produk',
            'Stok Masuk',
            'Catatan',
            'Created At',   
            'Updated At'            
        ];
    }

    public function map($riwayat_stok_produk): array
    {
        return [
            $riwayat_stok_produk->id,
            $riwayat_stok_produk->produk->nama_produk,
            $riwayat_stok_produk->ukuran_produk,
            $riwayat_stok_produk->stok_masuk,
            $riwayat_stok_produk->catatan,
            $riwayat_stok_produk->created_at,
            $riwayat_stok_produk->updated_at,
        ];
    }

    public function collection()
    {
        return RiwayatStokProduk::all();
    }

    public function title(): string
    {
        return 'Riwayat Stok Produk - ' . $this->timestamp;
    }
}
