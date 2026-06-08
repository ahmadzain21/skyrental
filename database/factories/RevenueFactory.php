<?php

namespace Database\Factories;

use App\Models\Booking;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Revenue>
 */
class RevenueFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $start = Carbon::now()->subDays(rand(0, 365))->setTime(rand(8, 20), 0);
        
        return [
            'booking_id' => Booking::factory(), // otomatis buat booking baru jika tidak ada
            'amount' => $this->faker->randomFloat(2, 100000, 1000000), // 100rb - 1jt
            'created' => $start
        ];
    }
}
