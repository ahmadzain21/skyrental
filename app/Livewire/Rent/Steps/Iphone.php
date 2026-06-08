<?php

namespace App\Livewire\Rent\Steps;

use App\Models\Iphones;
use Livewire\Component;
use Carbon\Carbon;
use Livewire\Attributes\Modelable;

class Iphone extends Component
{

    public $iphones;
    public ?int $selectedIphoneId = null;
    #[Modelable]
    public $requested_booking_date = null;
    #[Modelable]
    public $requested_time;
    public $end_booking_date;
    public $end_time;

    public function selectIphone(int $iphoneId)
    {
        $this->selectedIphoneId = $iphoneId;
        $this->dispatch('iphone-selected', iphoneId: $iphoneId);
    }

    public function mount()
    {
        $now = Carbon::now('Asia/Jakarta');

        $this->requested_booking_date = $now->toDateString(); // Y-m-d
        $this->requested_time = $now->format('H:i');
    }

    public function loadIphones()
    {
        $now = Carbon::now('Asia/Jakarta');

        $this->iphones = Iphones::with(['bookings' => function ($query) {
            $query->whereIn('status', ['pending', 'confirmed']);
        }])
            ->get()
            ->map(function ($iphone) use ($now) {

                $iphone->is_available = true;

                foreach ($iphone->bookings as $booking) {

                    $bookingStart = Carbon::parse(
                        "{$booking->requested_booking_date} {$booking->requested_time}",
                        'Asia/Jakarta'
                    );

                    $bookingEnd = $bookingStart->copy()
                        ->addHours((int) $booking->duration);

                    // ❌ booking sedang aktif SEKARANG
                    if ($bookingStart->lte($now) && $bookingEnd->gt($now)) {
                        $iphone->is_available = false;
                        break;
                    }
                }

                return $iphone;
            });
    }


    public function render()
    {
        return view('livewire.rent.steps.iphone', [
            'iphones' => $this->loadIphones()
        ]);
    }
}
