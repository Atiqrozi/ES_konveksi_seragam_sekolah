<?php

namespace App\Charts\GajiPegawai;

use ArielMejiaDev\LarapexCharts\LarapexChart;
use App\Models\GajiPegawai;

class GajiChart
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build(): \ArielMejiaDev\LarapexCharts\barChart
    {
        $gaji_pegawais = GajiPegawai::all();
        
        $nama_pegawai = [];
        $gaji = [];

        foreach ($gaji_pegawais as $gaji_pegawai) {
            $nama_pegawai[] = $gaji_pegawai->user->nama;
            $gaji[] = $gaji_pegawai->total_gaji_yang_bisa_diajukan;
        }

        return $this->chart->barChart()
            ->addData('Gaji Yang Bisa Diajukan', $gaji)
            ->setXAxis($nama_pegawai)
            ->setColors(['#a51b0a']);
    }
}
