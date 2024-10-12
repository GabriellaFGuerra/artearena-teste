<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Bill>
 */
class BillFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(),
            'description' => fake()->sentence(),
            'amount' => fake()->numberBetween(100, 1000),
            'due_date' => fake()->dateTimeBetween('now', '+1 year')->format('date'),
            'status' => fake()->randomElement(['pending', 'paid']),
        ];
    }
}
