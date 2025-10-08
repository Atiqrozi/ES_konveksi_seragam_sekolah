<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class Admin_Export_Excel implements FromCollection, WithHeadings, WithMapping
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

    public function map($admin): array
    {
        return [
            $admin->id,
            $admin->nama,
            $admin->email,
            $admin->alamat,
            $admin->no_telepon,
            $admin->jenis_kelamin,
            optional($admin->tanggal_lahir)->format('Y-m-d'),
            $admin->created_at,
            $admin->updated_at,
        ];
    }

    public function collection()
    {
        return User::role('Admin')->get();
    }

    public function title(): string
    {
        return 'Admin - ' . $this->timestamp;
    }
}
