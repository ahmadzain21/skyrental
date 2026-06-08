<?php

namespace App\Livewire\Reports;

use App\Models\Booking;
use App\Models\Iphones;
use App\Models\Revenue;
use Livewire\Component;

class TopDevice extends Component
{
    public $search = '';
    public $sortField = 'created_at';
    public $sortDirection = 'desc';
    public $paginate = 10;

    public $mySelected = [];
    public $selectedAll = false;
    // public $devices = [];

    public $totalBookings;
    public $totalDevices;
    public $totalAvailable;
    public $topDevice;
    public $revenueTotal;

    public function getDataDevice()
    {
        // Ambil query dasar dengan eager loading
        $query = Iphones::withCount('bookings')
            ->with(['revenues', 'bookings']);

        // 🔍 SEARCH
        if ($this->search) {
            $query->search([
                'name', // nama iPhone
                'revenues.amount', // total revenue relasi
                'bookings.customer_name',
                'bookings.customer_phone',
            ], $this->search);
        }

        // Eksekusi query
        $devices = $query->get();

        // 💰 Hitung total revenue keseluruhan
        $totalRevenue = Revenue::sum('amount');
        $this->revenueTotal = $totalRevenue;

        // 🔄 Map ke data siap tampil
        $devices = $devices->map(function ($device) use ($totalRevenue) {
            $totalPendapatan = $device->revenues->sum('amount');

            return [
                'nama' => $device->name,
                'created' => $device->created_at,
                'updated_at' => $device->updated_at,
                'total_disewa' => $device->bookings_count,
                'total_pendapatan' => $totalPendapatan,
                'kontribusi' => $totalRevenue > 0
                    ? round(($totalPendapatan / $totalRevenue) * 100, 2)
                    : 0,
            ];
        });

        // 🔽 SORTING (berdasarkan input dropdown)
        if ($this->sortField === 'amount') {
            $devices = $devices->sortBy([
                ['total_pendapatan', $this->sortDirection],
            ])->values();
        } elseif ($this->sortField === 'bookings') {
            $devices = $devices->sortBy([
                ['total_disewa', $this->sortDirection],
            ])->values();
        } elseif (in_array($this->sortField, ['created', 'updated_at'])) {
            $devices = $devices->sortBy([
                [$this->sortField, $this->sortDirection],
            ])->values();
        }

        // 🏆 Top device berdasarkan kontribusi
        $this->topDevice = $devices->sortByDesc('kontribusi')->first();

        // 📊 Statistik tambahan
        $this->totalBookings = Booking::count();
        $this->totalDevices = Iphones::count();
        $this->totalAvailable = Iphones::whereDoesntHave('bookings', function ($q) {
            $q->where('status', 'confirmed');
        })->count();

        return $devices;
    }




    public function render()
    {
        return view('livewire.reports.top-device', [
            'devices' => $this->getDataDevice()
        ]);
    }
}
