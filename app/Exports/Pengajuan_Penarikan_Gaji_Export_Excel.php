<?php

namespace App\Exports;

use App\Models\PenarikanGaji;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Illuminate\Support\Facades\Auth;

class Pengajuan_Penarikan_Gaji_Export_Excel implements FromCollection, WithHeadings, WithMapping
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

    public function map($pengajuan_penarikan_gaji): array
    {
        return [
            $pengajuan_penarikan_gaji->id,
            $pengajuan_penarikan_gaji->user->nama,
            $pengajuan_penarikan_gaji->gaji_yang_diajukan,
            $pengajuan_penarikan_gaji->status,
            $pengajuan_penarikan_gaji->mulai_tanggal,
            $pengajuan_penarikan_gaji->akhir_tanggal,
            $pengajuan_penarikan_gaji->gaji_diberikan,
        ];
    }

    public function collection()
    {
        return PenarikanGaji::where('pegawai_id', 'LIKE', Auth::user()->id)->get();
    }

    public function title(): string
    {
        return 'Pengajuan Penarikan Gaji ( ' . Auth::user()->nama . ' ) - ' . $this->timestamp;
    }
}
