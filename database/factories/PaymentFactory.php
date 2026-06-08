<?php

namespace Database\Factories;

use App\Models\Booking;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Payment>
 */
class PaymentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->randomElement(['bank_transfer', 'qris', 'cash']),
            'slug' => $this->faker->unique()->slug(),
            'icon' => $this->faker->optional()->imageUrl(64, 64, 'payment'),
            'description' => $this->faker->optional()->sentence(),
            'is_active' => $this->faker->boolean(80), // 80%
        ];
    }
}
