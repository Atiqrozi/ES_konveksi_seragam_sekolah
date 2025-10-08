<?php

namespace App\Exports;

use App\Models\UkuranProduk;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class UkuranProduk_Export_Excel implements FromCollection, WithHeadings, WithMapping
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
            'Stok',
            'Harga 1',
            'Harga 2',
            'Harga 3',
            'Harga 4',
            'Created At',   
            'Updated At'            
        ];
    }

    public function map($ukuran_produk): array
    {
        return [
            $ukuran_produk->id,
            $ukuran_produk->produk->nama_produk,
            $ukuran_produk->ukuran,
            $ukuran_produk->stok,
            $ukuran_produk->harga_produk_1,
            $ukuran_produk->harga_produk_2,
            $ukuran_produk->harga_produk_3,
            $ukuran_produk->harga_produk_4,
            $ukuran_produk->created_at,
            $ukuran_produk->updated_at,
        ];
    }

    public function collection()
    {
        return UkuranProduk::all();
    }

    public function title(): string
    {
        return 'Ukuran Produk - ' . $this->timestamp;
    }
}
