<?php

namespace App\Livewire\Analytics;

use App\Models\Booking;
use Carbon\Carbon;
use Livewire\Component;

class BookingsChart extends Component
{
    public $postBy = 'days';
    public $booking;

    public function render()
    {
        // $this->updatedPostBy($this->postBy);
        $bookings =  $this->postBy === 'days' ? $this->postViewByDays() : (
            $this->postBy === 'weeks' ? $this->postViewByWeeks() :
            $this->postViewByMonth()
        );
        $this->booking = $bookings;
        $this->dispatch('refresh-chart-data-bookings', $bookings);

        return view('livewire.analytics.bookings-chart', [
            'bookings' => $bookings
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
            $views = Booking::whereBetween('created', [$startOfDay, $endOfDay])->count();
            $dates[] = $date->format('l');
            $viewsData[] = $views;
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

            $views = Booking::whereBetween('created', [$startOfWeek, $endOfWeek])->count();

            $dates[] = 'Week ' . $startOfWeek->format('W'); // Nomor minggu
            $viewsData[] = $views;
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

            $views = Booking::whereBetween('created', [$startOfMonth, $endOfMonth])->count();

            $dates[] = $startOfMonth->format('M Y'); // Contoh: Jan 2025
            $viewsData[] = $views;
        }

        return [
            'date' => $dates,
            'data' => $viewsData
        ];
    }
}
