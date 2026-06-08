<?php

namespace App\Livewire;

use App\Models\Booking;
use App\Models\ReturnIphone;
use App\Models\Revenue;
use Carbon\Carbon;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use Livewire\Attributes\On;
use Livewire\Component;

class DetailBooking extends Component
{
    public Booking $booking;

    public $detailBookingIphones;
    public $returns;
    public $condition;
    public $bookingId;
    public int $hours = 1;
    public bool $available = true;
    public $newEnd = '';
    public $durations;
    public $selectedDurationId = null;
    public int $multiplier = 1;
    public $totalHours;
    public $sumRevenues;

    public function getRevenue()
    {
        $this->sumRevenues = Booking::findOrFail($this->booking->id)->revenue()->sum('amount');
    }

    #[On('get-detail')]
    public function getDetailIphone($id)
    {
        $this->detailBookingIphones = Booking::with([
            'revenue',
            'iphone.durations',
            'payment',
            'returns',
        ])->findOrFail($id);

        $this->booking = $this->detailBookingIphones;
        $this->durations = $this->booking->iphone->durations
            ->sortBy('hours')
            ->values();

        $this->bookingId = $this->detailBookingIphones->id;
        $this->getRevenue();
        $this->durations = $this->booking->iphone
            ->durations()
            ->orderBy('hours')
            ->get();
        $this->returns = $this->detailBookingIphones->returns()->latest()->get();
        $this->recalculate();
    }

    #[On('modal-durasi')]
    public function reRender()
    {
        $this->durations = $this->booking->iphone->durations
            ->sortBy('hours')
            ->values();
    }

    public function updated($property)
    {
        $this->durations = $this->booking->iphone->durations
            ->sortBy('hours')
            ->values();

        if (in_array($property, ['selectedDurationId', 'multiplier'])) {
            $this->recalculate();
        }
    }

    private function recalculate()
    {
        if (! $this->selectedDurationId || $this->multiplier < 1) {
            $this->resetPreview();
            return;
        }

        $duration = $this->durations
            ->firstWhere('id', $this->selectedDurationId);

        if (! $duration) {
            $this->resetPreview();
            return;
        }

        $this->totalHours = $duration->hours * $this->multiplier;

        $end = Carbon::parse(
            "{$this->booking->end_booking_date} {$this->booking->end_time}",
            'Asia/Jakarta'
        );

        $newEnd = $end->copy()->addHours($this->totalHours);
        $this->newEnd = $newEnd->format('d M Y H:i');

        $this->available = $this->booking->canExtend($this->totalHours);
    }

    public function recalculatePreview()
    {
        if (! $this->selectedDurationId) {
            $this->totalHours = 0;
            $this->newEnd = null;
            return;
        }

        $duration = $this->booking
            ->iphone
            ->durations()
            ->where('durations.id', $this->selectedDurationId)
            ->first();

        if (! $duration) {
            $this->totalHours = 0;
            $this->newEnd = null;
            return;
        }

        // Hitung total jam
        $this->totalHours = $duration->hours * $this->multiplier;

        $endDateTime = $this->booking->end_booking_date . ' ' . $this->booking->end_time;

        // Hitung waktu selesai baru
        $this->newEnd = \Carbon\Carbon::parse($endDateTime)
            ->addHours($this->totalHours)
            ->format('d M Y H:i');
    }


    private function resetPreview()
    {
        $this->totalHours = 0;
        $this->newEnd = '';
        $this->available = false;
    }


    public function extend()
    {
        if (! $this->available || $this->totalHours < 1) {
            return;
        }

        $duration = $this->booking
            ->iphone
            ->durations()
            ->where('durations.id', $this->selectedDurationId)
            ->first();

        if (! $duration) return;

        $this->booking->extendHours($this->totalHours);
        Revenue::create([
            'booking_id' => $this->booking->id,
            'amount' => $duration->pivot->price * $this->multiplier,
            'type' => 'extend',
            'created' => now('Asia/Jakarta'),
        ]);

        // Reset UI
        $this->selectedDurationId = null;
        $this->multiplier = 1;
        $this->durations = $this->booking->iphone->durations
            ->sortBy('hours')
            ->values();
        $this->getRevenue();
        $this->resetPreview();
        $this->dispatch('modal-durasi');
        LivewireAlert::title('Berhasil menambahkandurasi!')
            ->text('Durasi berhasil ditambahkan ke booking')
            ->success()
            ->toast()
            ->position('top-end')
            ->show();
    }

    public function changeMultiplier(string $action): void
    {
        $this->durations = $this->booking->iphone->durations
            ->sortBy('hours')
            ->values();

        switch ($action) {
            case 'increase':
                $this->multiplier++;
                break;

            case 'decrease':
                if ($this->multiplier > 1) {
                    $this->multiplier--;
                }
                break;
        }
        $this->recalculatePreview();
    }


    public function save()
    {
        $return = new ReturnIphone([
            'returned_at' => Carbon::now('Asia/Jakarta'),
            'condition'   => $this->condition,
        ]);

        // assign booking_id dulu
        $return->booking()->associate($this->detailBookingIphones);

        // baru hitung penalty
        $return->penalty_fee = $return->calculatePenalty();

        // simpan
        $return->save();


        // reset input
        $this->reset('condition');
        $this->updateStatusBooking($this->detailBookingIphones->id, 'returned');
        $this->dispatch('close-modal');
    }




    public function updateStatusBooking($bookingId, $status)
    {
        if (auth()->user()->can('update')) {
            try {
                $booking = Booking::find($bookingId);
                $booking->update(['status' => $status]);
                LivewireAlert::title('Status berhasil diubah')
                    ->position('top-end')
                    ->text('Status booking telah diperbarui')
                    ->toast()
                    ->success()
                    ->show();
            } catch (\Throwable $th) {
                LivewireAlert::title('Gagal mengubah status')
                    ->position('top-end')
                    ->text($th)
                    ->timer(5000)
                    ->error()
                    ->show();
            }
        } else {
            LivewireAlert::title('Kamu tidak memiliki izin')
                ->position('top-end')
                ->text('Tidak dapat mengubah status booking')
                ->timer(5000)
                ->error()
                ->show();
        }

        $this->dispatch('status-updated')->self(); // bisa dipakai untuk toast
    }

    #[On('status-updated')]
    public function refreshStatus() {}

    public function render()
    {
        return view('livewire.detail-booking');
    }
}
