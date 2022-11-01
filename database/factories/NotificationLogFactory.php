<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\NotificationLog>
 */
class NotificationLogFactory extends Factory
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
            'customer_id' => fn() => User::factory(),
            'chat_id' => fake()->boolean(30) ? random_int(1, 5000) : null,
            'body' => fake()->sentence,
            'type' => fake()->boolean ? 'Order' : 'Notification', 
        ];
    }
}
