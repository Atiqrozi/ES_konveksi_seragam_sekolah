<?php

namespace App\Charts\User;

use ArielMejiaDev\LarapexCharts\LarapexChart;

class JenisKelaminAdminChart
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
                \App\Models\User::where('jenis_kelamin', '=', 'Laki-Laki')->role('Admin')->count(),
                \App\Models\User::where('jenis_kelamin', '=', 'Perempuan')->role('Admin')->count()
            ])
            ->setLabels(['Laki-Laki', 'Perempuan'])
            ->setColors(['#44bbf7', '#f3519a']);
    }
}
