<?php

namespace App\Charts\RiwayatKegiatan;

use ArielMejiaDev\LarapexCharts\LarapexChart;
use App\Models\Kegiatan;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class KegiatanPegawaiChart
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build($startDate = null, $endDate = null): \ArielMejiaDev\LarapexCharts\BarChart
    {
        // Get the authenticated user ID
        $userId = Auth::user()->id;

        // Set default values for start and end dates if not provided
        $startDate = $startDate ? Carbon::parse($startDate) : Carbon::now()->subDays(7);
        $endDate = $endDate ? Carbon::parse($endDate) : Carbon::now();

        // Fetch activities with status 'Selesai' for the authenticated user within the date range
        $kegiatans = Kegiatan::where('status_kegiatan', 'Sudah Ditarik')
                    ->where('user_id', $userId)
                    ->whereBetween('kegiatan_dibuat', [$startDate, $endDate])
                    ->with('item') // Ensure we fetch related item data
                    ->get();

        // Initialize arrays to hold dates and item activities
        $dates = [];
        $itemActivities = [];

        // Group activities by date and item
        foreach ($kegiatans as $kegiatan) {
            $date = Carbon::parse($kegiatan->kegiatan_dibuat)->format('Y-m-d');
            $itemName = $kegiatan->item->nama_item;

            // Ensure the date entry exists
            if (!isset($dates[$date])) {
                $dates[$date] = [];
            }

            // Ensure the item entry exists for the date
            if (!isset($dates[$date][$itemName])) {
                $dates[$date][$itemName] = 0;
            }

            // Sum the activities for each item on each date
            $dates[$date][$itemName] += $kegiatan->jumlah_kegiatan;
        }

        // Extract unique dates and sort them
        $uniqueDates = array_keys($dates);
        sort($uniqueDates);

        // Prepare the chart data
        $chart = $this->chart->barChart()
            ->setXAxis($uniqueDates);

        // Initialize an array to hold the items
        $items = [];

        // Fill item activity data for each date
        foreach ($uniqueDates as $date) {
            foreach ($dates[$date] as $itemName => $activityCount) {
                if (!isset($itemActivities[$itemName])) {
                    $itemActivities[$itemName] = [];
                }
                $itemActivities[$itemName][$date] = $activityCount;
                if (!in_array($itemName, $items)) {
                    $items[] = $itemName;
                }
            }
        }

        // Align data for each item according to unique dates
        foreach ($items as $item) {
            $seriesData = [];
            foreach ($uniqueDates as $date) {
                $seriesData[] = $itemActivities[$item][$date] ?? 0;
            }
            $chart->addData($item, $seriesData);
        }

        return $chart;
    }
}
