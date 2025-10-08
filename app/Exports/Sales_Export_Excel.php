<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class Sales_Export_Excel implements FromCollection, WithHeadings, WithMapping
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
            'Email',
            'Alamat',
            'No Telepon',
            'Jenis Kelamin',
            'Tagihan',
            'Tanggal Lahir',
            'Created At',   
            'Updated At'        
        ];
    }

    public function map($sale): array
    {
        return [
            $sale->id,
            $sale->nama,
            $sale->email,
            $sale->alamat,
            $sale->no_telepon,
            $sale->jenis_kelamin,
            $sale->tagihan,
            optional($sale->tanggal_lahir)->format('Y-m-d'),
            $sale->created_at,
            $sale->updated_at,
        ];
    }

    public function collection()
    {
        return User::role('Sales')->get();
    }

    public function title(): string
    {
        return 'Sales - ' . $this->timestamp;
    }
}
