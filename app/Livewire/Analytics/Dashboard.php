<?php

namespace App\Livewire\Analytics;

use App\Models\Booking;
use App\Models\Revenue;
use Carbon\Carbon;
use Livewire\Attributes\On;
use Livewire\Component;

class Dashboard extends Component
{
    public $total_revenues;
    public $bookings;

    public function mount()
    {
        $this->total_revenues = Revenue::sum('amount');
    }

    public function getRevenues()
    {
        $this->bookings = Booking::whereDate('created', Carbon::today())->with('iphone')->get();
        //  if ($property == 'days') {
        //     // Hari ini
        // } elseif ($property == 'weeks') {
        //     // Minggu ini (dari Senin sampai hari ini)
        //     $this->bookings = Booking::whereBetween('created', [
        //         Carbon::now()->startOfWeek(Carbon::MONDAY),
        //         Carbon::now()->endOfDay()
        //     ])->get();
        // } elseif ($property == 'year') {
        //     // Tahun ini
        //     $this->bookings = Booking::whereYear('created', Carbon::now()->year)->get();
        // }
    }

    #[On('update-revenues')]
    public function updateRevenues($property)
    {
        $this->getRevenues();
    }


    public function render()
    {
        return view('livewire.analytics.dashboard', [
            'total_revenues' => $this->total_revenues
        ]);
    }
}
