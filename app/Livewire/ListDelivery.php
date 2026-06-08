<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Booking;

class ListDelivery extends Component
{
    public $search = '';
    public $selectedBookings = [];
    public $selectedAll = false;

    public function getDeliveryBookingsProperty()
    {
        return Booking::where('pickup_type', 'delivery')
            ->where('customer_name', 'like', '%' . $this->search . '%')
            ->get();
    }

    public function getPendingDeliveryProperty()
    {
        return Booking::where('pickup_type', 'delivery')
            ->where('status', 'pending')
            ->get();
    }

    public function updatedSelectedAll($value)
    {
        if ($value) {
            $this->selectedBookings = $this->deliveryBookings->pluck('id')->toArray();
        } else {
            $this->selectedBookings = [];
        }
    }

    public function autoSelectByTime()
    {
        $this->selectedBookings = Booking::where('pickup_type', 'delivery')
            ->whereTime('start_time', '<=', now()->addHour())
            ->pluck('id')
            ->toArray();
    }

    public function generateRoute()
    {
        if (empty($this->selectedBookings)) {
            session()->flash('error', 'Pilih minimal 1 booking');
            return;
        }

        return redirect()->route('delivery.map', [
            'ids' => implode(',', $this->selectedBookings)
        ]);
    }

    public function markDelivered($id)
    {
        Booking::find($id)->update([
            'status' => 'delivered'
        ]);
    }

    public function showRoute($id)
    {
        return redirect()->route('delivery.map', $id);
    }

    public function render()
    {
        return view('livewire.list-delivery', [
            'deliveryBookings' => $this->deliveryBookings,
            'pendingDelivery' => $this->pendingDelivery
        ]);
    }
}
