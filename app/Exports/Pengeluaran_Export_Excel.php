<?php

namespace App\Exports;

use App\Models\Pengeluaran;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class Pengeluaran_Export_Excel implements FromCollection, WithHeadings, WithMapping
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
            'Jenis Pegawai',
            'Rincian',
            'Jumlah',
            'Tanggal'
        ];
    }

    public function map($pengeluaran): array
    {
        return [
            $pengeluaran->id,
            $pengeluaran->jenis_pengeluaran->nama_pengeluaran,
            $pengeluaran->keterangan,
            $pengeluaran->jumlah,
            $pengeluaran->tanggal,
        ];
    }

    public function collection()
    {
        return Pengeluaran::all();
    }

    public function title(): string
    {
        return 'Pengeluaran - ' . $this->timestamp;
    }
}
