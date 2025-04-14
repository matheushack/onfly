<?php

namespace Database\Factories;

use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'passenger' => fake()->name(),
            'destination' => fake()->name(),
            'departure_at' => Carbon::now()->format('Y-m-d'),
            'return_at' => Carbon::now()->addDays(30)->format('Y-m-d'),
        ];
    }
}
