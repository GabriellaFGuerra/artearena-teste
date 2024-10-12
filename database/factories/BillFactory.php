<?php

namespace Database\Factories;

use Carbon\Carbon;
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
            'due_date' => Carbon::now()->addDays(rand(1, 60))->format('Y-m-d'),
            'status' => fake()->randomElement(['pending', 'paid']),
        ];
    }
}
