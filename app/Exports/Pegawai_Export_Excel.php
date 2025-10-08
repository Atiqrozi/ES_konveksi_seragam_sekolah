<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class Pegawai_Export_Excel implements FromCollection, WithHeadings, WithMapping
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
            'Tanggal Lahir',
            'Created At',   
            'Updated At'        
        ];
    }

    public function map($pegawai): array
    {
        return [
            $pegawai->id,
            $pegawai->nama,
            $pegawai->email,
            $pegawai->alamat,
            $pegawai->no_telepon,
            $pegawai->jenis_kelamin,
            optional($pegawai->tanggal_lahir)->format('Y-m-d'),
            $pegawai->created_at,
            $pegawai->updated_at,
        ];
    }

    public function collection()
    {
        return User::role('Pegawai')->get();
    }

    public function title(): string
    {
        return 'Pegawai - ' . $this->timestamp;
    }
}
