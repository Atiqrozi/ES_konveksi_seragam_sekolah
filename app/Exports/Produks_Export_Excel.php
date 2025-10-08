<?php

namespace App\Exports;

use App\Models\Produk;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class Produks_Export_Excel implements FromCollection, WithHeadings, WithMapping
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
            'Nama',
            'Kategori',
            'Deskripsi',
            'Created At',
            'Updated At'
        ];
    }

    public function map($produk): array
    {
        return [
            $produk->id,
            $produk->nama_produk,
            $produk->kategori->nama,
            $produk->deskripsi_produk,
            $produk->created_at,
            $produk->updated_at,
        ];
    }

    public function collection()
    {
        return Produk::all();
    }

    public function title(): string
    {
        return 'Produk - ' . $this->timestamp;
    }
}
