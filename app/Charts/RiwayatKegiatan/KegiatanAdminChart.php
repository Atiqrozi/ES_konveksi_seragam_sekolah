<?php

namespace App\Charts\RiwayatKegiatan;

use ArielMejiaDev\LarapexCharts\LarapexChart;
use App\Models\Kegiatan;
use Carbon\Carbon;

class KegiatanAdminChart
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build($startDate, $endDate): \ArielMejiaDev\LarapexCharts\AreaChart
    {
        // Get completed activities with related user data within the specified date range
        $kegiatans = Kegiatan::where('status_kegiatan', 'Sudah Ditarik')
            ->whereBetween('kegiatan_dibuat', [$startDate, $endDate])
            ->with('user')
            ->get();

        // Initialize arrays to hold dates and user activities
        $dates = [];
        $userActivities = [];

        // Group activities by date and user
        foreach ($kegiatans as $kegiatan) {
            $date = Carbon::parse($kegiatan->kegiatan_dibuat)->format('Y-m-d');
            $userName = $kegiatan->user->nama;

            // Ensure the date entry exists
            if (!isset($dates[$date])) {
                $dates[$date] = [];
            }

            // Ensure the user entry exists for the date
            if (!isset($dates[$date][$userName])) {
                $dates[$date][$userName] = 0;
            }

            // Sum the activities for each user on each date
            $dates[$date][$userName] += $kegiatan->jumlah_kegiatan;
        }

        // Extract unique dates and sort them
        $uniqueDates = array_keys($dates);
        sort($uniqueDates);

        // Prepare the chart data
        $chart = $this->chart->areaChart();

        // Initialize an array to hold the users
        $users = [];

        // Fill user activity data for each date
        foreach ($uniqueDates as $date) {
            foreach ($dates[$date] as $userName => $activityCount) {
                if (!isset($userActivities[$userName])) {
                    $userActivities[$userName] = [];
                }
                $userActivities[$userName][$date] = $activityCount;
                if (!in_array($userName, $users)) {
                    $users[] = $userName;
                }
            }
        }

        // Add the series data to the chart
        foreach ($users as $user) {
            $seriesData = [];
            foreach ($uniqueDates as $date) {
                $seriesData[] = $userActivities[$user][$date] ?? 0;
            }
            $chart->addData($user, $seriesData);
        }

        // Set the X-axis as the unique sorted dates
        return $chart->setXAxis($uniqueDates)
                     ->setTitle('Riwayat Kegiatan dari ' . $startDate . ' hingga ' . $endDate)
                     ->setColors(['#a51b0a']);
    }
}
