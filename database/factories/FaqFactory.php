<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Faq>
 */
class FaqFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'question' => $this->faker->sentence(6), // contoh: "Bagaimana cara menyewa iPhone?"
            'answer' => $this->faker->paragraph(3),   // jawaban panjang
            'is_active' => $this->faker->boolean(80), // 80% aktif
            // 'created_by' => \App\Models\User::factory()->create()->id, // pastikan user ada
            // 'updated_by' => \App\Models\User::factory()->create()->id,
        ];
    }
}
