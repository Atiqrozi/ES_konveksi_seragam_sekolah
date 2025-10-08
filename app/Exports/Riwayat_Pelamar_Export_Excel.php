<?php

namespace App\Exports;

use App\Models\Pelamar;
use App\Models\Kriteria;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class Riwayat_Pelamar_Export_Excel implements FromCollection, WithHeadings, WithMapping
{
    protected $timestamp;
    protected $headings;

    public function __construct()
    {
        $this->timestamp = now()->format('Y-m-d_H-i-s');
        $this->headings = $this->getHeadings();
    }

    public function headings(): array
    {
        return $this->headings;
    }

    public function map($pelamar): array
    {
        $values = [];

        // Ambil nilai dari setiap kriteria menggunakan relasi wsmPelamar
        $wsmPelamar = $pelamar->wsmPelamar->keyBy('kriteria_id');

        foreach ($this->getKriteria() as $kriterium) {
            $values[] = $wsmPelamar->has($kriterium->id) ? $wsmPelamar[$kriterium->id]->skor : '-';
        }

        return [
            $pelamar->id,
            $pelamar->nama,
            $pelamar->email,
            $pelamar->alamat,
            $pelamar->no_telepon,
            $pelamar->jenis_kelamin,
            $pelamar->tanggal_lahir,
            $pelamar->pendidikan_terakhir,
            $pelamar->pengalaman,
            $pelamar->status,
            ...$values,
            $pelamar->weighted_sum_model,
            $pelamar->created_at,
            $pelamar->updated_at,
        ];
    }

    public function collection()
    {
        return Pelamar::whereIn('status', ['Diterima', 'Ditolak'])->get();
    }

    public function title(): string
    {
        return 'Pelamar - ' . $this->timestamp;
    }

    protected function getKriteria()
    {
        return Kriteria::orderBy('id')->get();
    }

    protected function getHeadings()
    {
        $headings = [
            'ID',
            'Nama',
            'Email',
            'Alamat',
            'Nomor Telepon',
            'Jenis Kelamin',
            'Tanggal Lahir',
            'Pendidikan Terakhir',
            'Pengalaman',
            'Status',
        ];

        $kriteria = $this->getKriteria();

        foreach ($kriteria as $kriterium) {
            $headings[] = $kriterium->nama . ' (' . $kriterium->bobot . ')';
        }

        $headings[] = 'Weighted Sum Model';
        $headings[] = 'Created At';
        $headings[] = 'Updated At';

        return $headings;
    }
}
