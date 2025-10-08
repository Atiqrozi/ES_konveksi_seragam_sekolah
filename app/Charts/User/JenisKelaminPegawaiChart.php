<?php

namespace App\Charts\User;

use ArielMejiaDev\LarapexCharts\LarapexChart;

class JenisKelaminPegawaiChart
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build(): \ArielMejiaDev\LarapexCharts\PieChart
    {
        return $this->chart->pieChart()
            ->addData([
                \App\Models\User::where('jenis_kelamin', '=', 'Laki-Laki')->role('Pegawai')->count(),
                \App\Models\User::where('jenis_kelamin', '=', 'Perempuan')->role('Pegawai')->count()
            ])
            ->setLabels(['Laki-Laki', 'Perempuan'])
            ->setColors(['#44bbf7', '#f3519a']);
    }
}
