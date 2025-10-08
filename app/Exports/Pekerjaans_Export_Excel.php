<?php

namespace App\Exports;

use App\Models\Pekerjaan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class Pekerjaans_Export_Excel implements FromCollection, WithHeadings, WithMapping
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
            'Gaji Per Pekerjaan',
            'Deskripsi',
            'Created At',   
            'Updated At'            
        ];
    }

    public function map($pekerjaan): array
    {
        return [
            $pekerjaan->id,
            $pekerjaan->nama_pekerjaan,
            $pekerjaan->gaji_per_pekerjaan,
            $pekerjaan->deskripsi_pekerjaan,
            $pekerjaan->created_at,
            $pekerjaan->updated_at,
        ];
    }

    public function collection()
    {
        return Pekerjaan::all();
    }

    public function title(): string
    {
        return 'Pekerjaan - ' . $this->timestamp;
    }
}
