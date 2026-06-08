<?php

namespace App\Livewire;

use App\Models\Booking;
use App\Models\Iphones;
use App\Models\Payment;
use App\Models\Review;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use Livewire\Attributes\On;
use Livewire\Component;
use Illuminate\Support\Facades\Http;

class Detail extends Component
{
    public $step = 1;
    public $terms_condition = false;

    public $iphone;
    public $selectedPrice;
    public $selectedDateFormatted; // 25 Juli 2025, 20:51
    public int $selectedDuration; // 24

    public $selectedDate; // Date object for the selected date
    public int $selectedHour; // 20
    public int $selectedMinute; // 10

    public $is_available = false;
    public $selectedIphoneId;
    public $customer_name;
    public $customer_phone;
    public $customer_email;
    public $countryCode = '+62';
    public $address;
    public $pickup_type = 'pickup';
    public $lat;
    public $long;
    public $jaminan_type = 'KTP';

    public $payments;
    public $selectedPaymentId = 1;
    public $selectedPayment;

    public $rating = 0;
    public $name;

    public $reviews;
    public $avgRating;


    public string $bookind_code;

    public ?int $jumlah = null;
    public $unit = '';
    public $totalHarga = 0;
    public int $basePricePerHour = 5000;

    public function next()
    {
        $this->validate([
            'selectedIphoneId'   => 'required|exists:iphones,id',
            'customer_name'      => 'required|string|max:255',
            'customer_phone'     => [
                'required',
                'regex:/^[0-9]{4}-[0-9]{4}-[0-9]{3}$/', // format: 8314-6838-432
            ],
            'customer_email'     => 'nullable|email|max:255',
            'selectedDuration'   => 'required|integer|min:1',
            'selectedPrice'      => 'required|numeric|min:0',
            'pickup_type' => 'required|in:pickup,delivery',
            'address' => $this->pickup_type === 'delivery'
                ? 'required|string|min:10|max:255'
                : 'required|string|min:10|max:255',
            'lat' => $this->pickup_type === 'delivery'
                ? 'required'
                : 'nullabel',
            'long' => $this->pickup_type === 'delivery'
                ? 'required'
                : 'nullabel',    
            'jaminan_type' => 'required|in:KTP,KK,Kartu Pelajar,SIM,Kartu Identitas Mahasiswa'
        ], [
            'customer_phone.regex' => 'Format nomor tidak boleh diawali 0 atau 62.',
        ]);

        if ($this->step < 2) {
            $this->step++;
        }
    }

    public function setCustom($unit)
    {
        $this->unit = $unit;
        $this->updateDurationAndPrice();
    }

    public function updatedJumlah()
    {
        // dd($this->jumlah);
        $this->updateDurationAndPrice();
    }

    private function updateDurationAndPrice()
    {
        // dd($this->jumlah);
        if ($this->unit === 'Jam' && $this->jumlah < 24) {
            $this->jumlah = 24;
        }

        if ($this->jumlah < 1) {
            $this->selectedDuration = 0;
            $this->selectedPrice = 0;
            return;
        }


        if ($this->basePricePerHour === 5000) {
            # code...
            switch ($this->unit) {

                case 'Hari':
                    $this->selectedDuration = $this->jumlah * 24;
                    break;
                case 'Minggu':
                    $this->selectedDuration = $this->jumlah * 24 * 7;
                    break;
                case 'Bulan':
                    $this->selectedDuration = $this->jumlah * 24 * 30; // asumsi 30 hari
                    break;
                default:
                    $this->selectedDuration = $this->jumlah;
                    break;
            }
        } else {
            switch ($this->unit) {

                case 'Hari':
                    $this->selectedDuration = $this->jumlah;
                    break;
                case 'Minggu':
                    $this->selectedDuration = $this->jumlah * 7;
                    break;
                case 'Bulan':
                    $this->selectedDuration = $this->jumlah * 30; // asumsi 30 hari
                    break;
                default:
                    $this->selectedDuration = $this->jumlah;
                    break;
            }
        }

        // hitung harga (contoh sederhana per jam)
        $this->selectedPrice = $this->selectedDuration * $this->basePricePerHour;
    }

    #[On('updated:selectedIphoneId')]
    #[On('updated:selectedDate')]
    #[On('updated:selectedHour')]
    #[On('updated:selectedMinute')]
    #[On('updated:selectedDuration')]
    #[On('updated:jumlah')]
    #[On('updated:unit')]
    public function updated()
    {
        $this->checkAvailability();
    }

    public function updatedSelectedPaymentId()
    {
        $this->selectedPayment = $this->payments->firstWhere('id', $this->selectedPaymentId);
        if (!$this->selectedPayment) {
            $this->selectedPaymentId = optional($this->payments->first())->id ?? null;
            $this->selectedPayment = $this->payments->first();
        }
    }

    public function checkAvailability()
    {
        try {
            $start = Carbon::parse($this->selectedDate)->setTimezone('Asia/Jakarta');
            $end = $start->copy()->addHours((int) $this->selectedDuration);
        } catch (\Exception $e) {
            $this->is_available = false;
            return;
        }

        $bookings = Booking::where('iphone_id', $this->selectedIphoneId)
            ->whereIn('status', ['pending', 'confirmed'])
            ->get();

        $this->is_available = true;

        // now = 2025-09-09 18:51:59.697095 Asia/Jakarta (+07:00)
        // start = 2025-09-09 19:28:35.515 Asia/Jakarta (+07:00)
        // end = 2025-09-10 19:28:35.515 Asia/Jakarta (+07:00)
        // bookingStart =  2025-09-08 15:35:00.0 Asia/Jakarta (+07:00)
        // bookingEnd = 2025-09-09 15:35:00.0 Asia/Jakarta (+07:00)

        foreach ($bookings as $booking) {
            $bookingStart = Carbon::parse("{$booking->requested_booking_date} {$booking->requested_time}", 'Asia/Jakarta');
            $bookingEnd = $bookingStart->copy()->addHours((int) $booking->duration);

            // Lewati booking yang sudah selesai
            if ($bookingEnd->lte(Carbon::now('Asia/Jakarta'))) {
                continue;
            }

            if ($start->lt($bookingEnd) && $end->gt($bookingStart)) {
                $this->is_available = false;
                break;
            }
        }
    }

    function generateAnonymousName(): string
    {
        $prefix = 'User';
        $code = strtoupper(Str::random(6)); // gunakan helper Laravel Str
        return "{$prefix}{$code}";
    }

    public function bookingNow()
    {
        if (!$this->is_available) {
            LivewireAlert::title('Waktu Tidak Tersedia')
                ->text('iPhone sedang dibooking pada waktu tersebut. Silakan pilih waktu lain.')
                ->error()
                ->toast()
                ->position('top-end')
                ->show();
            return;
        }

        $this->dispatch('open-modal', 'user-booking-create');
    }

    public function booking()
    {
        if ($this->jumlah > 1) {
            $this->selectedDuration = $this->selectedDuration * 24;
        }
        if (!$this->is_available) {
            LivewireAlert::title('Waktu Tidak Tersedia')
                ->text('iPhone sedang dibooking pada waktu tersebut. Silakan pilih waktu lain.')
                ->error()
                ->toast()
                ->position('top-end')
                ->show();
            return;
        }
        $this->validate([
            'selectedIphoneId'   => 'required|exists:iphones,id',
            'customer_name'      => 'required|string|max:255',
            'customer_phone'     => [
                'required',
                'regex:/^[0-9]{4}-[0-9]{4}-[0-9]{3}$/', // format: 8314-6838-432
            ],
            'customer_email'     => 'nullable|email|max:255',
            'selectedDuration'   => 'required|integer|min:1',
            'selectedPrice'      => 'required|numeric|min:0',
            'pickup_type' => 'required|in:pickup,delivery',
            'address' => $this->pickup_type === 'delivery'
                ? 'required|string|min:10|max:255'
                : 'nullable|string|max:255',
            'jaminan_type' => 'required|in:KTP,KK,Kartu Pelajar,SIM,Kartu Identitas Mahasiswa, Kartu Identitas Anak',
            'terms_condition' => 'accepted'
        ], [
            'customer_phone.regex' => 'Format nomor tidak boleh diawali 0 atau 62.',
        ]);

        //dd($this);

        $bookind_code = Booking::generateBookingCode();
        $booking = Booking::create([
            'iphone_id' => $this->selectedIphoneId,
            'customer_name' => $this->customer_name,
            'customer_phone' => $this->countryCode . '-' . $this->customer_phone,
            'customer_email' => $this->customer_email,

            'requested_booking_date' => Carbon::parse($this->selectedDate)->timezone('Asia/Jakarta')->toDateString(),
            'requested_time' => sprintf('%02d:%02d', $this->selectedHour, $this->selectedMinute),
            'duration' => $this->selectedDuration,
            'price' => $this->selectedPrice,
            'status' => 'pending',
            'created' => Carbon::now('Asia/Jakarta'),
            'booking_code' => $bookind_code,
            'address' => $this->address,
            'lat' => $this->lat,
            'long' => $this->long,
            'pickup_type' => $this->pickup_type,
            'payment_id' => $this->selectedPayment ? $this->selectedPayment->id : null,
            'jaminan_type' => $this->jaminan_type,
        ]);

        $message = "Halo {$booking->customer_name},\n\n"
            . "Terima kasih telah melakukan booking di *SkyRental*.\n\n"
            . "Berikut adalah detail booking Anda:\n"
            . "--------------------------------------\n"
            . "Kode Booking : *{$booking->booking_code}*\n"
            . "Perangkat    : {$booking->iphone->name} {$booking->iphone->serial_number}\n"
            . "Tanggal      : {$booking->requested_booking_date}\n"
            . "Waktu        : {$booking->requested_time}\n"
            . "Durasi       : {$booking->duration} jam\n"
            . "Total Biaya  : Rp" . number_format($booking->price, 0, ',', '.') . "\n"
            . "--------------------------------------\n\n"
            . "Mohon segera melakukan pembayaran *maksimal 30 menit* setelah pesan ini diterima.\n"
            . "Apabila pembayaran belum kami terima hingga batas waktu tersebut, "
            . "maka booking akan *dibatalkan secara otomatis*.\n\n"
            . "Setelah melakukan pembayaran, silakan lakukan konfirmasi dengan membalas pesan ini "
            . "atau mengirim bukti pembayaran melalui WhatsApp ini.\n\n"
            . "Untuk memeriksa status booking, silakan kunjungi:\n"
            . url('/booking-status') . "\n\n"
            . "Terima kasih atas kerja samanya.\n"
            . "SkyRental";

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
            . "🔗 <a href='" . url('/admin/bookings/') . "'>Lihat detail di Admin Panel</a>";


        $groupMessage = "BOOKING BARU MASUK\n\n"
            . "Perangkat    : {$booking->iphone->name} {$booking->iphone->serial_number}\n"
            . "Nama         : {$booking->customer_name}\n"
            . "No. HP       : {$booking->customer_phone}\n"
            . "Alamat       : {$booking->address}\n"
            . "Jaminan       : {$booking->jaminan_type}\n"
            . "Email        : {$booking->customer_email}\n\n"
            . "Kode Booking : {$booking->booking_code}\n"
            . "Tanggal      : {$booking->requested_booking_date}\n"
            . "Waktu        : {$booking->requested_time}\n"
            . "Durasi       : {$booking->duration} jam\n"
            . "Total Biaya  : Rp" . number_format($booking->price, 0, ',', '.') . "\n\n"
            . "Status       : {$booking->status} \n"
            . "Admin Panel:\n"
            . url('/admin/bookings/');

        $telegramToken   = config('services.telegram.bot_token');
        $chatId  = config('services.telegram.chat_id');
        $whatsappToken = config('services.fonnte.token');
        $group_chat_id = config('services.fonnte.groupid');


        Http::withHeaders([
            'Authorization' => $whatsappToken,
        ])->post('https://api.fonnte.com/send', [
            'target'  => $group_chat_id,
            'message' => $groupMessage,
        ]);

        Http::withHeaders([
            'Authorization' => $whatsappToken,
        ])->post('https://api.fonnte.com/send', [
            'target' => $this->formatPhoneNumber($booking->customer_phone), // hapus tanda "-" biar format sesuai
            'message' => $message,
        ]);

        Http::post("https://api.telegram.org/bot{$telegramToken}/sendMessage", [
            'chat_id'    => $chatId,
            'text'       => $adminMessage,
            'parse_mode' => 'HTML',
        ]);

        $this->dispatch('close-modal');
        $this->reset([
            'selectedIphoneId',
            'customer_name',
            'customer_phone',
            'customer_email',
            'selectedDate',
            'selectedHour',
            'selectedMinute',
            'selectedPrice',
            'jaminan_type'

        ]);

        $now = Carbon::now('Asia/Jakarta');
        $this->selectedHour = $now->format('H');
        $this->selectedMinute = $now->format('i');
        LivewireAlert::title('Booking Berhasil')
            ->text('Untuk memeriksa status booking, gunakan *Kode Booking* di halaman status booking')
            ->toast()
            ->position('top')
            ->success()
            ->timer(10000)
            ->show();

        $this->redirectRoute('booking.status', ['code' => $booking->booking_code]);
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

    public function mount(Iphones $iphone, $date, $hour, $minute)
    {
        $this->selectedDate = $date;
        $this->selectedHour = (int)$hour;
        $this->selectedMinute = (int)$minute;
        $this->iphone = $iphone;
        $now = Carbon::now('Asia/Jakarta');
        $this->selectedHour = $now->format('H');
        $this->selectedMinute = $now->format('i');
        $this->selectedIphoneId = $iphone->id;
        $this->selectedDuration = $iphone->durations->first()->hours ?? 1; // Default to first duration or 1 hour
        $this->selectedPrice = $iphone->durations->first()->pivot->price ?? 0; // Default to first duration price or 0
        $this->name = $this->generateAnonymousName();
        $this->getReviews();
        $this->basePricePerHour = $iphone->durations()->where('hours', 24)->first()->pivot->price ?? 5000;
    }

    #[On('get-reviews')]
    public function getReviews()
    {
        $this->reviews = Review::where('iphone_id', $this->selectedIphoneId)
            ->orderBy('created_at', 'desc')
            ->get();
        $this->avgRating = number_format(round($this->reviews->avg('rating') * 2) / 2, 1);
    }

    public function render()
    {
        $this->payments = Payment::where('is_active', true)->orderBy('created_at', 'desc')->get();
        $this->selectedPayment = $this->payments->firstWhere('id', $this->selectedPaymentId);

        if (!$this->selectedPayment) {
            $this->selectedPaymentId = optional($this->payments->first())->id ?? null;
            $this->selectedPayment = $this->payments->first();
        }
        return view('livewire.detail');
    }
}
