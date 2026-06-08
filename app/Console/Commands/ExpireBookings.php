<?php

namespace App\Console\Commands;

use App\Models\Booking;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class ExpireBookings extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bookings:expire';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Expire pending bookings that have not been paid within 30 minutes';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Cek booking yang statusnya 'pending' dan waktu sekarang sudah lewat dari requested_booking_date + requested_time + 30 menit
        // Jika ada, ubah statusnya menjadi 'expired' dan kirim notifikasi ke admin & customer
        $compareTime = now()->subMinutes(30); // Ubah ke 30 untuk produksi
        $token   = config('services.telegram.bot_token');
        $chatId  = config('services.telegram.chat_id');
        $whatsappToken = config('services.fonnte.token');

        $expiredBookings = Booking::where('status', 'pending')
            ->whereRaw(
                "STR_TO_DATE(CONCAT(requested_booking_date, ' ', requested_time), '%Y-%m-%d %H:%i:%s') < ?",
                [$compareTime]
            )
            ->get();
        foreach ($expiredBookings as $booking) {
            $this->info("Expiring booking ID: " . $booking->id);

            $booking->status = 'cancelled';
            $booking->save();

            $adminMessage = "<b>Booking Expired</b> ❌\n\n"
                . "📌 Kode Booking : <b>{$booking->booking_code}</b>\n"
                . "Customer     : {$booking->customer_name}\n"
                . "Perangkat    : {$booking->iphone->name}\n"
                . "Tanggal      : {$booking->requested_booking_date}\n"
                . "Waktu        : {$booking->requested_time}\n"
                . "Durasi       : {$booking->duration} jam\n"
                . "Total Biaya  : Rp" . number_format($booking->price, 0, ',', '.') . "\n\n"
                . "Booking ini telah otomatis diubah menjadi status <b>Cancelled</b> karena lewat 30 menit tanpa pembayaran.";


            // Pesan ke Admin via Telegram
            Http::post("https://api.telegram.org/bot{$token}/sendMessage", [
                'chat_id'    => $chatId,
                'text'       => $adminMessage,
                'parse_mode' => 'HTML',
            ]);

            // Pesan ke Customer via Fonnte
            $message = "Halo {$booking->customer_name}, 👋\n\n"
                . "Kami ingin menginformasikan bahwa booking Anda di *SkyRental* 📱✨\n\n"
                . "📌 Kode Booking : *{$booking->booking_code}*\n"
                . "Perangkat    : {$booking->iphone->name}\n"
                . "Tanggal      : {$booking->requested_booking_date}\n"
                . "Waktu        : {$booking->requested_time}\n"
                . "Durasi       : {$booking->duration} jam\n"
                . "Total Biaya  : Rp" . number_format($booking->price, 0, ',', '.') . "\n"
                . "──────────────────────\n\n"
                . "⏰ Booking Anda telah *dibatalkan* karena tidak melakukan pembayaran dalam waktu 30 menit.\n\n"
                . "Jika masih ingin melanjutkan, silakan lakukan booking ulang melalui website kami:\n"
                . url('/') . "\n\n"
                . "Terima kasih 🙏\n"
                . "*SkyRental*";

            Http::withHeaders([
                'Authorization' => $whatsappToken,
            ])->post('https://api.fonnte.com/send', [
                'target'  => $booking->customer_phone,
                'message' => $message,
            ]);
        }
    }
}
