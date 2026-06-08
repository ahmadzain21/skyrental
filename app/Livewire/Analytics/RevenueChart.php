<?php

namespace App\Livewire\Analytics;

use App\Models\Revenue;
use Carbon\Carbon;
use Livewire\Component;

class RevenueChart extends Component
{
    public $postBy = 'days';

    public function updatedPostBy($properyName)
    {
        $this->dispatch('update-revenues', property: $properyName);
    }
    
    public function render()
    {
        // $this->updatedPostBy($this->postBy);
        $revenues =  $this->postBy === 'days' ? $this->postViewByDays() : (
            $this->postBy === 'weeks' ? $this->postViewByWeeks() :
            $this->postViewByMonth()
        );
        $this->dispatch('refresh-chart-data', $revenues);
        return view('livewire.analytics.revenue-chart', [
            'revenues' => $revenues
        ]);
    }

    public function postViewByDays()
    {
        $today = Carbon::today();
        $sixDaysAgo = Carbon::today()->subDays(6);

        $dates = [];
        $viewsData = [];
        for ($date = $sixDaysAgo->copy(); $date <= $today; $date->addDay()) {
            $startOfDay = $date->copy()->startOfDay();
            $endOfDay = $date->copy()->endOfDay();
            $views = Revenue::whereBetween('created_at', [$startOfDay, $endOfDay])
                ->sum('amount');
            $dates[] = $date->format('l');
            $viewsData[] = round($views);
        }
        return [

            'date' => $dates,
            'data' => $viewsData
        ];
    }

    public function postViewByWeeks()
    {
        $today = Carbon::today();
        $startWeek = $today->copy()->subWeeks(7)->startOfWeek();

        $dates = [];
        $viewsData = [];

        for ($i = 0; $i < 8; $i++) {
            $startOfWeek = $startWeek->copy()->addWeeks($i)->startOfWeek();
            $endOfWeek = $startOfWeek->copy()->endOfWeek();

            $views = Revenue::whereBetween('created_at', [$startOfWeek, $endOfWeek])->sum('amount');

            $dates[] = 'Week ' . $startOfWeek->format('W'); // Nomor minggu
            $viewsData[] = round($views);
        }
        // dd($dates, $viewsData);

        return [
            'date' => $dates,
            'data' => $viewsData
        ];
    }


    public function postViewByMonth()
    {
        $today = Carbon::today();
        $startMonth = $today->copy()->subMonths(11)->startOfMonth(); // 12 bulan ke belakang termasuk bulan ini

        $dates = [];
        $viewsData = [];

        for ($i = 0; $i < 12; $i++) {
            $startOfMonth = $startMonth->copy()->addMonths($i)->startOfMonth();
            $endOfMonth = $startOfMonth->copy()->endOfMonth();

            $views = Revenue::whereBetween('created_at', [$startOfMonth, $endOfMonth])->sum('amount');

            $dates[] = $startOfMonth->format('M Y'); // Contoh: Jan 2025
            $viewsData[] = round($views);
        }

        return [
            'date' => $dates,
            'data' => $viewsData
        ];
    }
}
