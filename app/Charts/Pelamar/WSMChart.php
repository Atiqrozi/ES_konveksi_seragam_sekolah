<?php

namespace App\Charts\Pelamar;

use ArielMejiaDev\LarapexCharts\LarapexChart;

class WSMChart
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build(): \ArielMejiaDev\LarapexCharts\LineChart
    {
        // Menghitung jumlah pelamar berdasarkan rentang nilai weighted_sum_model
        $ranges = [
            'Skor 0-1' => \App\Models\Pelamar::whereBetween('weighted_sum_model', [0, 1])->whereIn('status', ['Diajukan', 'Belum Wawancara', 'Sudah Wawancara'])->count(),
            'Skor 1-2' => \App\Models\Pelamar::whereBetween('weighted_sum_model', [1, 2])->whereIn('status', ['Diajukan', 'Belum Wawancara', 'Sudah Wawancara'])->count(),
            'Skor 2-3' => \App\Models\Pelamar::whereBetween('weighted_sum_model', [2, 3])->whereIn('status', ['Diajukan', 'Belum Wawancara', 'Sudah Wawancara'])->count(),
            'Skor 3-4' => \App\Models\Pelamar::whereBetween('weighted_sum_model', [3, 4])->whereIn('status', ['Diajukan', 'Belum Wawancara', 'Sudah Wawancara'])->count(),
            'Skor 4-5' => \App\Models\Pelamar::whereBetween('weighted_sum_model', [4, 5])->whereIn('status', ['Diajukan', 'Belum Wawancara', 'Sudah Wawancara'])->count(),
        ];

        return $this->chart->lineChart()
            ->setTitle('Distribusi WSM (Weighted Sum Model) Pelamar')
            ->addData('Jumlah Pelamar', array_values($ranges))
            ->setXAxis(array_keys($ranges))
            ->setColors(['#a51b0a']);
    }
}
