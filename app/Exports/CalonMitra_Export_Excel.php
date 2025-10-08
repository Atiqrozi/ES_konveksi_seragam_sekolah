<?php

namespace App\Exports;

use App\Models\CalonMitra;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class CalonMitra_Export_Excel implements FromCollection, WithHeadings, WithMapping
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
            'Nomor Whatsapp',
            'Alamat',
            'Created At',     
        ];
    }

    public function map($calon_mitra): array
    {
        return [
            $calon_mitra->id,
            $calon_mitra->nama,
            $calon_mitra->nomor_wa,
            $calon_mitra->alamat,
            $calon_mitra->created_at,
        ];
    }

    public function collection()
    {
        return CalonMitra::all();
    }

    public function title(): string
    {
        return 'Calon Mitra - ' . $this->timestamp;
    }
}
