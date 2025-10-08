<?php

namespace App\Exports;

use App\Models\GajiPegawai;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class Gaji_Semua_Pegawai_Export_Excel implements FromCollection, WithHeadings, WithMapping
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
            'Nama Pegawai',
            'Gaji Tersedia',  
            'Terhitung Tanggal'            
        ];
    }

    public function map($gaji_semua_pegawai): array
    {
        return [
            $gaji_semua_pegawai->id,
            $gaji_semua_pegawai->user->nama,
            $gaji_semua_pegawai->total_gaji_yang_bisa_diajukan,
            $gaji_semua_pegawai->updated_at,
        ];
    }

    public function collection()
    {
        return GajiPegawai::all();
    }

    public function title(): string
    {
        return 'Gaji Semua Pegawai - ' . $this->timestamp;
    }
}
