<?php

namespace App\Livewire\Booking;

use App\Models\Booking;
use App\Models\Iphones;
use App\Models\Payment;
use Carbon\Carbon;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use Livewire\Component;
use Illuminate\Support\Facades\Http;

class Create extends Component
{
    public $iphones;
    public $search = '';
    public $sortField = 'created_at';
    public $sortDirection = 'desc';
    public $paginate = 10;
    public $selectedIphone = null;
    public $countryCode = '+62';

    public $selectedPrice = null;

    public $iphone_id;
    public $customer_name;
    public $customer_phone;
    public $customer_email;
    public $selectedIphoneId = null;
    public $requested_booking_date;
    public $requested_time;
    public $end_booking_date;
    public $end_time;
    public $price = 0; // Assuming you have a way to calculate or set this

    public $payments;
    public $selectedPaymentId = 1;
    public $selectedPayment;

    public $selectedDuration = null;

    public $durations = [];
    public $sendWhatsapp = true;

    public function updatedSelectedPaymentId()
    {
        $this->selectedPayment = $this->payments->firstWhere('id', $this->selectedPaymentId);
        if (!$this->selectedPayment) {
            $this->selectedPaymentId = optional($this->payments->first())->id ?? null;
            $this->selectedPayment = $this->payments->first();
        }
    }

    public function save()
    {
        // Validasi input awal
        $this->validate([
            'selectedIphoneId' => 'required|exists:iphones,id',
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'required|string|max:15',
            'customer_email' => 'nullable|email|max:255',
            'requested_booking_date' => 'required|date',
            'requested_time' => 'required|date_format:H:i',
            'selectedDuration' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
        ]);

        // 🔄 Hitung end_booking_date dan end_time terlebih dahulu
        $this->calculateEndDateTime();

        if (!$this->end_booking_date || !$this->end_time) {
            LivewireAlert::title('Gagal Hitung Waktu')
                ->text('Gagal menghitung waktu selesai booking.')
                ->error()
                ->toast()
                ->position('top-end')
                ->show();
            return;
        }

        // Gabungkan tanggal dan waktu dari booking sekarang
        $start = Carbon::createFromFormat('Y-m-d H:i', Carbon::parse($this->requested_booking_date)->format('Y-m-d') . ' ' . $this->requested_time);
        $end = Carbon::createFromFormat('Y-m-d H:i', Carbon::parse($this->end_booking_date)->format('Y-m-d') . ' ' . $this->end_time);

        // 🔍 Cek apakah ada booking bentrok
        $bookings = Booking::where('iphone_id', $this->selectedIphoneId)
            ->whereIn('status', ['pending', 'confirmed'])
            ->get();

        $conflict = $bookings->contains(function ($booking) use ($start, $end) {
            $bookingStart = Carbon::parse($booking->requested_booking_date . ' ' . $booking->requested_time);

            // Hitung bookingEnd berdasarkan requested + durasi
            $bookingEnd = $bookingStart->copy()->addHours((int) $booking->duration);

            // Cek apakah waktu booking lama bertabrakan dengan booking baru
            return $bookingStart < $end && $bookingEnd > $start;
        });

        if ($conflict) {
            LivewireAlert::title('Booking Gagal')
                ->text('Tanggal dan waktu yang dipilih sudah dibooking.')
                ->error()
                ->toast()
                ->position('top-end')
                ->show();
            return;
        }
        // Simpan booking baru
        $booking = Booking::create([
            'iphone_id' => $this->selectedIphoneId,
            'customer_name' => $this->customer_name,
            'customer_phone' => $this->countryCode . '-' . $this->customer_phone,
            'customer_email' => $this->customer_email,
            'requested_booking_date' => carbon()->now()->toDateString(),
            'requested_time' => Carbon::now()->format('H:i'),
            // 'end_booking_date' => $end->toDateString(),
            // 'end_time' => $end->format('H:i'),
            'duration' => $this->selectedDuration,
            'price' => $this->selectedPrice,
            'status' => 'pending',
            'created' => Carbon::now('Asia/Jakarta'),
            'booking_code' => Booking::generateBookingCode(),
            'payment_id' => $this->selectedPayment ? $this->selectedPayment->id : null,
        ]);

        $message = "Halo {$booking->customer_name}, 👋\n\n"
            . "Terima kasih telah melakukan booking di *SkyRental* 📱✨\n\n"
            . "Berikut adalah detail booking Anda:\n"
            . "──────────────────────\n"
            . "📌 Kode Booking : *{$booking->booking_code}*\n"
            . "Perangkat    : {$booking->iphone->name}\n"
            . "Tanggal      : {$booking->requested_booking_date}\n"
            . "Waktu        : {$booking->requested_time}\n"
            . "Durasi       : {$booking->duration} jam\n"
            . "Total Biaya  : Rp" . number_format($booking->price, 0, ',', '.') . "\n"
            . "──────────────────────\n\n"
            . "Untuk memeriksa status booking Anda, silakan kunjungi link berikut:\n"
            . url('/booking-status') . "\n\n"
            . "Mohon pastikan nomor WhatsApp yang Anda gunakan benar agar dapat menerima informasi lebih lanjut.\n\n"
            . "Terima kasih 🙏\n"
            . "*SkyRental*";

        $adminMessage = "📢 <b>Booking Baru Diterima</b>\n\n"
            . "<b>Nama</b> : {$booking->customer_name}\n"
            . "<b>HP</b>   : {$booking->customer_phone}\n"
            . "<b>Email</b>: {$booking->customer_email}\n\n"
            . "<b>Kode Booking</b>: {$booking->booking_code}\n"
            . "<b>Perangkat</b>   : {$booking->iphone->name}\n"
            . "<b>Tanggal</b>     : {$booking->requested_booking_date}\n"
            . "<b>Waktu</b>       : {$booking->requested_time}\n"
            . "<b>Durasi</b>      : {$booking->duration} jam\n"
            . "<b>Total Biaya</b>: Rp" . number_format($booking->price, 0, ',', '.') . "\n\n"
            . "🔗 <a href='" . url('/admin/bookings/' . $booking->id) . "'>Lihat detail di Admin Panel</a>";

        $token = env('TELEGRAM_BOT_TOKEN'); // simpan token di .env
        $chatId = env('TELEGRAM_CHAT_ID'); // chat id kamu

        if ($this->sendWhatsapp) {
            Http::withHeaders([
                'Authorization' => env('FONNTE_TOKEN'),
            ])->post('https://api.fonnte.com/send', [
                'target' => $this->formatPhoneNumber($booking->customer_phone), // hapus tanda "-" biar format sesuai
                'message' => $message,
            ]);
    
            Http::post("https://api.telegram.org/bot{$token}/sendMessage", [
                'chat_id'    => $chatId,
                'text'       => $adminMessage,
                'parse_mode' => 'HTML',
            ]);
        }
        

        // Reset
        $this->dispatch('close-modal');
        $this->reset([
            'selectedDuration',
            'selectedIphone',
            'selectedIphoneId',
            'customer_name',
            'customer_phone',
            'customer_email',
            'requested_booking_date',
            'end_booking_date',
            'requested_time',
            'end_time',
            'price'
        ]);
        $this->requested_booking_date = Carbon::now('Asia/Jakarta');
        $this->requested_time = Carbon::now('Asia/Jakarta')->format('H:i');
        LivewireAlert::title('Success!')
            ->text('Booking berhasil disimpan.')
            ->success()
            ->toast()
            ->position('top-end')
            ->show();
    }

    public function getDuration()
    {
        if ($this->selectedIphoneId) {
            $iphone = Iphones::with('durations')->find($this->selectedIphoneId);
            $this->durations = $iphone->durations->map(function ($duration, $index) {
                return [
                    'index' => $index,
                    'hours' => $duration->hours,           // dari tabel durations
                    'price' => (int) $duration->pivot->price, // dari pivot table
                ];
            })->toArray();
        }
    }

    public function calculateEndDateTime()
    {
        if (!$this->requested_booking_date || !$this->requested_time || !$this->selectedDuration) {
            $this->end_booking_date = null;
            $this->end_time = null;
            return;
        }

        try {
            $dateOnly = Carbon::parse($this->requested_booking_date)->toDateString(); // pastikan hanya tanggal
            $startDateTime = Carbon::parse("{$dateOnly} {$this->requested_time}");

            $endDateTime = $startDateTime->copy()->addHours($this->selectedDuration);

            $this->end_booking_date = $endDateTime->toDateString();
            $this->end_time = $endDateTime->format('H:i');
        } catch (\Exception $e) {
            logger()->error('DateTime parse error: ' . $e->getMessage());
            $this->end_booking_date = null;
            $this->end_time = null;
        }
    }

    public function mount()
    {
        $this->requested_booking_date = Carbon::now('Asia/Jakarta');
        $this->payments = Payment::orderBy('created_at', 'desc')->get();
        $this->selectedPayment = $this->payments->firstWhere('id', $this->selectedPaymentId);

        if (!$this->selectedPayment) {
            $this->selectedPaymentId = optional($this->payments->first())->id ?? null;
            $this->selectedPayment = $this->payments->first();
        }
        $this->requested_time = Carbon::now('Asia/Jakarta')->format('H:i');
    }

    public function getData()
    {
        return Iphones::query()
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%');
            })->orderBy($this->sortField, $this->sortDirection)->get();
    }

    function formatPhoneNumber($phone)
    {
        // hapus semua karakter non-digit
        $digits = preg_replace('/\D/', '', $phone);

        // kalau nomor sudah diawali 62 -> biarkan
        if (substr($digits, 0, 2) === '62') {
            return $digits;
        }

        // kalau diawali 0 -> ubah ke 62
        if (substr($digits, 0, 1) === '0') {
            return '62' . substr($digits, 1);
        }

        return $digits;
    }

    public function render()
    {
        return view('livewire.booking.create', [
            'iphonesQuery' => $this->getData()
        ]);
    }
}
