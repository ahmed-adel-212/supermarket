<?php

namespace Database\Factories;

use App\Models\City;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Area>
 */
class AreaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'city_id' => fn() => City::factory(),
            'name' => [
                'en' => fake()->city,
                'ar' => fake('ar_SA')->city,
            ],
            'description' => [
                'en' => fake()->text,
                'ar' => fake('ar_SA')->realText,
            ],
            'delivery_fees' => fake()->boolean(40) ? fake()->randomFloat(2) : 0,
        ];
    }
}
