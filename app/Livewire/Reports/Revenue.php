<?php

namespace App\Livewire\Reports;

use App\Models\Revenue as ModelsRevenue;
use Livewire\Component;

class Revenue extends Component
{
    public $search = '';
    public $sortField = 'created_at';
    public $sortDirection = 'desc';
    public $paginate = 10;

    public $mySelected = [];
    public $selectedAll = false;

    public $revenueToday;
    public $revenueThisMonth;
    public $revenueTotal;
    public $revenueLastMonth;
    public $revenuePenalty;
    public $revenueThisMonthPercentage;

    public function mount()
    {
        $today = now()->toDateString();
        $startOfThisMonth = now()->startOfMonth()->toDateString();
        $endOfLastMonth = now()->subMonth()->endOfMonth()->toDateString();
        $startOfLastMonth = now()->subMonth()->startOfMonth()->toDateString();

        // Revenue Hari Ini
        $this->revenueToday = ModelsRevenue::whereDate('created_at', $today)->sum('amount');

        // Revenue Bulan Ini
        $this->revenueThisMonth = ModelsRevenue::whereBetween('created_at', [$startOfThisMonth, now()])->sum('amount');

        // Revenue Bulan Lalu
        $this->revenueLastMonth = ModelsRevenue::whereBetween('created_at', [$startOfLastMonth, $endOfLastMonth])->sum('amount');

        // Revenue Total
        $this->revenueTotal = ModelsRevenue::sum('amount');

        $this->revenuePenalty = ModelsRevenue::where('type', 'penalty')->sum('amount');

        
        // Persentase Kenaikan/Penurunan Bulan Ini vs Bulan Lalu
        if ($this->revenueLastMonth > 0) {
            $growth = (($this->revenueThisMonth - $this->revenueLastMonth) / $this->revenueLastMonth) * 100;
            $this->revenueThisMonthPercentage = round($growth, 2); // + atau - persentase
        } else {
            $this->revenueThisMonthPercentage = $this->revenueThisMonth > 0 ? 100 : 0;
        }
    }


    public function getData()
    {
        $query = ModelsRevenue::query()
            ->with(['booking.iphone']); // Eager load relasi booking dan iphone

        if ($this->search) {
            // Sesuaikan dengan kolom dan relasi yang kamu ingin cari
            $query->search([
                'amount',
                'booking.name',          // Misal: nama pemesan
                'booking.description',   // Misal: keterangan booking
                'booking.iphone.model',  // Jika ingin cari berdasarkan model iPhone
                'updated_at'
            ], $this->search);
        }

        if (in_array($this->sortField, ['created_at', 'updated_at'])) {
            $query->orderBy($this->sortField, $this->sortDirection);
        }

        return $query;
    }



    public function render()
    {
        $query = $this->getData()->paginate($this->paginate);
        return view('livewire.reports.revenue', [
            'revenues' => $query
        ]);
    }
}
