<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Testimony>
 */
class TestimonyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'client' => fake()->name(),
            'testimony' => fake()->sentence(),
            'category' => [fake()->randomElement(['Renovasi', 'Furniture', 'Bangun Baru'])],
        ];
    }
}
