<?php

namespace App\Charts\Pesanan;

use ArielMejiaDev\LarapexCharts\LarapexChart;
use App\Models\Invoice;
use Carbon\Carbon;

class PemasukanChart
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build($startDate = null, $endDate = null): \ArielMejiaDev\LarapexCharts\AreaChart
    {
        // Default to the latest 7 days if no date range is provided
        if (!$startDate) {
            $endDate = Carbon::now();
            $startDate = $endDate->copy()->subDays(7);
        } else {
            $startDate = Carbon::parse($startDate);
            $endDate = Carbon::parse($endDate);
        }

        $invoices = Invoice::whereBetween('created_at', [$startDate, $endDate])->get();

        $tanggal = [];
        $pemasukan = [];

        foreach ($invoices as $invoice) {
            $tanggal[] = $invoice->created_at->format('Y-m-d');
            $pemasukan[] = $invoice->sub_total;
        }

        return $this->chart->areaChart()
            ->setTitle('Pemasukan Dari ' . $startDate->format('d M Y') . ' hingga ' . $endDate->format('d M Y'))
            ->addData('Pemasukan', $pemasukan)
            ->setXAxis($tanggal)
            ->setColors(['#a51b0a']);
    }
}

