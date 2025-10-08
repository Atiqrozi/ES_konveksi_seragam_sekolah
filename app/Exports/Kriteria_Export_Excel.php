<?php

namespace App\Exports;

use App\Models\Kriteria;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class Kriteria_Export_Excel implements FromCollection, WithHeadings, WithMapping
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
            'Bobot',
            'Created At',   
            'Updated At'            
        ];
    }

    public function map($kriteria): array
    {
        return [
            $kriteria->id,
            $kriteria->nama,
            $kriteria->bobot,
            $kriteria->created_at,
            $kriteria->updated_at,
        ];
    }

    public function collection()
    {
        return Kriteria::all();
    }

    public function title(): string
    {
        return 'Kriteria - ' . $this->timestamp;
    }
}
