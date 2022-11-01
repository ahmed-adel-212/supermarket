<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\User;
use Arr;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PointTransaction>
 */
class PointTransactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'user_id' => fn() => User::factory(),
            'order_id' => fn() => Order::factory(),
            'points' => random_int(20, 500),
            'price' => fake()->randomFloat(2, 50, 1000),
            'status' => Arr::random(['pending', 'used', 'gained']),
        ];
    }
}
