<?php

namespace App\Console\Commands;

use App\Models\Booking;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class NotifyReturnBooking extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bookings:notify-return';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Notify customers about upcoming booking return';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //
        $telegramToken   = config('services.telegram.bot_token');
        $chat_id = config('services.telegram.chat_id');
        $whatsappToken = config('services.fonnte.token');


        $now = now();
        $compareTime = now()->addMinutes(30);

        $bookings = Booking::where('status', 'confirmed')
            ->where('reminder_sent', false)
            ->whereRaw(
                "STR_TO_DATE(CONCAT(end_booking_date, ' ', end_time), '%Y-%m-%d %H:%i:%s') BETWEEN ? AND ?",
                [$now, $compareTime]
            )
            ->get();
        foreach ($bookings as $booking) {
            $adminMessage = "⚠️ *Reminder Booking Akan Berakhir*\n\n"
                . "Booking dengan detail berikut akan segera berakhir:\n\n"
                . "Kode Booking: *{$booking->booking_code}*\n"
                . "Customer: *{$booking->customer_name}*\n"
                . "Whatsapp Number: *{$booking->customer_phone}*\n"
                . "iPhone ID: {$booking->iphone_id}\n"
                . "Berakhir: " . Carbon::parse($booking->end_booking_date)->format('d M Y')
                . "Waktu" . Carbon::parse($booking->end_time)->format('H:i') . " WIB\n\n"
                . "Silakan pantau pengembalian unit.";
            $message = "⚠️ *Pengingat Pengembalian iPhone*\n\n"
                . "Halo *{$booking->customer_name}*,\n\n"
                . "Masa sewa iPhone Anda dengan kode booking *{$booking->booking_code}* akan segera berakhir pada:\n"
                . "Tanggal: " . Carbon::parse($booking->end_booking_date)->format('d M Y') . "\n"
                . "Waktu: " . Carbon::parse($booking->end_time)->format('H:i') . " WIB\n\n"
                . "Mohon pastikan untuk mengembalikan unit tepat waktu. Apabila ada kendala, silakan hubungi admin kami.\n\n"
                . "Terima kasih 🙏";


            // Kirim ke Admin via Telegram
            Http::post("https://api.telegram.org/bot{$telegramToken}/sendMessage", [
                'chat_id'    => $chat_id,
                'text'       => $adminMessage,
                'parse_mode' => 'Markdown', // gunakan Markdown agar *teks tebal* terbaca
            ]);

            // Kirim ke Customer via WhatsApp
            Http::withHeaders([
                'Authorization' => $whatsappToken,
            ])->post('https://api.fonnte.com/send', [
                'target'  => $booking->customer_phone,
                'message' => $message,
            ]);

            $booking->update(['reminder_sent' => true]);
            $this->info("Reminder sent to booking ID {$booking->id}");
        }
    }
}
