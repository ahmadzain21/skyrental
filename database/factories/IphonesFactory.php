<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Iphones>
 */
class IphonesFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->unique()->word(),
            'description' => $this->faker->sentence(),
            'slug' => $this->faker->unique()->slug(),
            'gallery_id' => \App\Models\Gallery::factory()->create()->id,
            'user_id' => \App\Models\User::factory()->create()->id,
        ];
    }
}
