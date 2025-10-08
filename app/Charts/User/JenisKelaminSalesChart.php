<?php

namespace App\Charts\User;

use ArielMejiaDev\LarapexCharts\LarapexChart;

class JenisKelaminSalesChart
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
                \App\Models\User::where('jenis_kelamin', '=', 'Laki-Laki')->role('Sales')->count(),
                \App\Models\User::where('jenis_kelamin', '=', 'Perempuan')->role('Sales')->count()
            ])
            ->setLabels(['Laki-Laki', 'Perempuan'])
            ->setColors(['#44bbf7', '#f3519a']);
    }
}
