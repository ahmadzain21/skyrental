<?php

namespace Database\Factories;

use App\Models\Booking;
use App\Models\Iphones;
use App\Models\Payment;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Booking>
 */
class BookingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Acak tanggal mulai antara 0 sampai 365 hari ke belakang
        $start = Carbon::now()->subDays(rand(0, 365))->setTime(rand(8, 20), 0);
        
        // Durasi dalam jam (6, 12, atau 24)
        $durations = [6, 12, 24];
        $duration = $this->faker->randomElement($durations);

        $end = (clone $start)->addHours($duration);

        return [
            'iphone_id' => Iphones::factory(),
            'payment_id' => null, // Atau bisa diisi dengan Payment::inRandomOrder()->first()->id jika sudah ada data
            'customer_name' => $this->faker->name(),
            'customer_phone' => '08' . $this->faker->numerify('########'),
            'customer_email' => $this->faker->optional()->safeEmail(),

            'price' => $this->faker->randomFloat(2, 50000, 500000),

            'start_booking_date' => $start->toDateString(),
            'start_time' => $start,
            'end_booking_date' => $end->toDateString(),
            'end_time' => $end,
            'duration' => $duration,

            'status' => $this->faker->randomElement(['pending', 'confirmed', 'returned', 'cancelled']),
            
            // Created timestamp dummy (acak dalam 1 tahun terakhir)
            'created' => $start,
        ];
    }
}
