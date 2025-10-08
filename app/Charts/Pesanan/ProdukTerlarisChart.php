<?php

namespace App\Charts\Pesanan;

use ArielMejiaDev\LarapexCharts\LarapexChart;
use App\Models\Pesanan;

class ProdukTerlarisChart
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build(): \ArielMejiaDev\LarapexCharts\barChart
    {
        $pesanans = Pesanan::all();
        
        $produkData = [];

        foreach ($pesanans as $pesanan) {
            $nama_produk = $pesanan->produk->nama_produk;
            if (isset($produkData[$nama_produk])) {
                $produkData[$nama_produk] += $pesanan->jumlah_pesanan;
            } else {
                $produkData[$nama_produk] = $pesanan->jumlah_pesanan;
            }
        }

        $nama_produk = array_keys($produkData);
        $produk_terjual = array_values($produkData);

        return $this->chart->barChart()
            ->addData('Produk Terjual', $produk_terjual)
            ->setXAxis($nama_produk)
            ->setColors(['#a51b0a']);
    }
}
