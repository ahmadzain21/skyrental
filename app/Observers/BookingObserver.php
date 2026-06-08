<?php

namespace App\Observers;

use App\Models\Booking;
use App\Models\Revenue;
use Carbon\Carbon;

class BookingObserver
{
    /**
     * Handle the Booking "created" event.
     */
    public function created(Booking $booking): void
    {
        //
    }

    /**
     * Handle the Booking "updated" event.
     */
    public function updated(Booking $booking): void
    {
        if (!$booking->start_booking_date && $booking->requested_booking_date) {
            $start = Carbon::createFromFormat('Y-m-d H:i:s', $booking->requested_booking_date . ' ' . $booking->requested_time);

            $end = $start->copy()->addHours((int) $booking->duration);

            $booking->start_booking_date = $start->toDateString();
            $booking->start_time = $start->format('H:i');
            $booking->end_booking_date = $end->toDateString();
            $booking->end_time = $end->format('H:i');

            $booking->saveQuietly(); // agar tidak loop observer
        }

        if (!$booking->revenue && $booking->status !== 'cancelled') {
            
            Revenue::create([
                'booking_id' => $booking->id,
                'amount' => $booking->price,
                'type' =>  'booking',
                'created' => now('Asia/Jakarta'),
            ]);
        }
    }

    /**
     * Handle the Booking "deleted" event.
     */
    public function deleted(Booking $booking): void
    {
        //
    }

    /**
     * Handle the Booking "restored" event.
     */
    public function restored(Booking $booking): void
    {
        //
    }

    /**
     * Handle the Booking "force deleted" event.
     */
    public function forceDeleted(Booking $booking): void
    {
        //
    }
}
