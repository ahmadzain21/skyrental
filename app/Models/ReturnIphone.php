<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class ReturnIphone extends Model
{
    //
    protected $fillable = [
        'booking_id',
        'returned_at',
        'condition',
        'penalty_fee',
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    public function calculatePenalty()
    {
        if (!$this->booking) {
            return 0;
        }

        // Gabungkan tanggal & jam akhir booking → lalu parse ke Carbon
        $endDateTime = Carbon::parse(
            $this->booking->end_booking_date . ' ' . $this->booking->end_time,
            'Asia/Jakarta'
        );

        // Waktu pengembalian (default ke sekarang kalau belum ada)
        $returnedAt = $this->returned_at
            ? Carbon::parse($this->returned_at, 'Asia/Jakarta')
            : Carbon::now('Asia/Jakarta');

        // Hitung selisih jam
        $hoursLate = $returnedAt->greaterThan($endDateTime)
            ? $endDateTime->diffInHours($returnedAt)
            : 0;
        return $hoursLate * 5000;
    }

    protected static function booted()
    {
        static::created(function ($returnIphone) {
            // hanya kalau ada denda
            if ($returnIphone->penalty_fee > 5000) {
                Revenue::create([
                    'booking_id' => $returnIphone->booking_id,
                    'amount'     => $returnIphone->penalty_fee,
                    'type'       => 'penalty',
                    'created'    => now(),
                ]);
            }
        });
    }
}
