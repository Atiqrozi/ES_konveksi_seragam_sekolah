<?php

namespace App\Exports;

use App\Models\PenarikanGaji;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Illuminate\Support\Facades\Auth;

class Riwayat_Penarikan_Gaji_Export_Excel implements FromCollection, WithHeadings, WithMapping
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
            'Gaji Ditarik',  
            'Status',
            'Terhitung Tanggal',
            'Sampai Tanggal',
            'Gaji Diberikan Tanggal'       
        ];
    }

    public function map($riwayat_penarikan_gaji): array
    {
        return [
            $riwayat_penarikan_gaji->id,
            $riwayat_penarikan_gaji->user->nama,
            $riwayat_penarikan_gaji->gaji_yang_diajukan,
            $riwayat_penarikan_gaji->status,
            $riwayat_penarikan_gaji->mulai_tanggal,
            $riwayat_penarikan_gaji->akhir_tanggal,
            $riwayat_penarikan_gaji->gaji_diberikan,
        ];
    }

    public function collection()
    {
        return PenarikanGaji::all();
    }

    public function title(): string
    {
        return 'Riwayat Penarikan Gaji (Semua) - ' . $this->timestamp;
    }
}
