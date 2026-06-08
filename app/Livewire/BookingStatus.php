<?php

namespace App\Livewire;

use App\Models\Booking;
use App\Models\PaymentProof;
use Carbon\Carbon;
use Livewire\Component;
use Illuminate\Support\Facades\Http;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use Livewire\WithFileUploads;

class BookingStatus extends Component
{

    use WithFileUploads;

    public $bookingCode;
    public $booking;
    public $expireAt;
    public $payment_proof;

    public function mount($code)
    {
        $this->bookingCode = $code;
        if ($this->bookingCode) {
            $this->checkBooking();
        }
    }

    public function checkBooking()
    {
        $this->booking = Booking::with(['payment', 'iphone'])
            ->where('booking_code', $this->bookingCode)
            ->first();

        if ($this->booking) {
            $requestedAt = Carbon::parse($this->booking->requested_booking_date . ' ' . $this->booking->requested_time);
            $this->expireAt = $requestedAt->copy()->addMinutes(30)->timestamp;
        } else {
            $this->addError('bookingCode', 'Kode booking tidak ditemukan.');
        }

        if (!$this->booking) {
            $this->addError('bookingCode', 'Kode booking tidak ditemukan.');
        }
    }

    public function cancelBooking()
    {
        if ($this->booking->status === 'pending') {
            $this->booking->update([
                'status' => 'cancelled',
            ]);
        }

        // refresh data biar status terbaru kebaca di view
        $this->booking->refresh();
    }

    public function confirmPayment($bookingId)
    {
        $booking = Booking::with('payment')
            ->where('id', $bookingId)
            ->where('booking_code', $this->bookingCode)
            ->first();

        $paymentProof = $booking->paymentProofs()->latest()->first();

        if ($paymentProof === null || !$paymentProof->is_confirm) {
            $this->validate([
                'payment_proof' => 'required|mimes:jpg,jpeg,png,pdf|max:2048',
                'bookingCode'   => 'required|string',
            ]);

            $this->booking = Booking::with(['payment', 'iphone'])
                ->where('booking_code', $this->bookingCode)
                ->first();

            PaymentProof::create([
                'booking_id' => $this->booking->id,
                'file_path'  => $this->payment_proof->store('payment_proofs', 'public'),
                'is_confirm' => true
            ]);

            $token   = config('services.telegram.bot_token');
            $chatId  = config('services.telegram.chat_id');

            $message = "📢 <b>Konfirmasi Pembayaran</b>\n\n"
                . "<b>Kode Booking</b>: {$booking->booking_code}\n"
                . "<b>Nama</b> : {$booking->customer_name}\n"
                . "<b>Total</b>: Rp" . number_format($booking->price, 0, ',', '.') . "\n\n"
                . "Customer telah menekan tombol <b>Konfirmasi Pembayaran</b>.\n"
                . "Silakan admin melakukan pengecekan.";

            Http::post("https://api.telegram.org/bot{$token}/sendMessage", [
                'chat_id'    => $chatId,
                'text'       => $message,
                'parse_mode' => 'HTML',
            ]);

            LivewireAlert::title('Konfirmasi Pembayaran Berhasil')
                ->position('top-end')
                ->text('Tunggu admin untuk memproses pembayaran ini.')
                ->timer(5000)
                ->toast()
                ->success()
                ->show();

            $this->dispatch('close-modal');
        } else {
            LivewireAlert::title('Konfirmasi Pembayaran Gagal')
                ->position('top-end')
                ->text('Kamu sudah melakukan konfirmasi, tunggu admin status berubah')
                ->timer(5000)
                ->toast()
                ->error()
                ->show();
        }
    }


    public function render()
    {
        return view('livewire.booking-status');
    }
}
