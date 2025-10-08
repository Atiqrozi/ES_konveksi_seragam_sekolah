<?php

namespace App\Exports;

use App\Models\Artikel;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class Artikel_Export_Excel implements FromCollection, WithHeadings, WithMapping
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
            'Penulis',
            'Judul',
            'Slug',
            'Created At',   
            'Updated At'        
        ];
    }

    public function map($artikel): array
    {
        return [
            $artikel->id,
            $artikel->user->nama,
            $artikel->judul,
            $artikel->slug,
            $artikel->created_at,
            $artikel->updated_at,
        ];
    }

    public function collection()
    {
        return Artikel::all();
    }

    public function title(): string
    {
        return 'Artikel - ' . $this->timestamp;
    }
}
