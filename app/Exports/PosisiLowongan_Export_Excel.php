<?php

namespace App\Exports;

use App\Models\PosisiLowongan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class PosisiLowongan_Export_Excel implements FromCollection, WithHeadings, WithMapping
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
            'Nama Posisi',
            'Deskripsi Posisi',
            'Created At',   
            'Updated At'            
        ];
    }

    public function map($posisi_lowongan): array
    {
        return [
            $posisi_lowongan->id,
            $posisi_lowongan->nama_posisi,
            $posisi_lowongan->deskripsi_posisi,
            $posisi_lowongan->created_at,
            $posisi_lowongan->updated_at,
        ];
    }

    public function collection()
    {
        return PosisiLowongan::all();
    }

    public function title(): string
    {
        return 'Posisi Lowongan - ' . $this->timestamp;
    }
}
