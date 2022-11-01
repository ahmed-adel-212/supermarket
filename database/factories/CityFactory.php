<?php

namespace Database\Factories;

use App\Models\Government;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\City>
 */
class CityFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'government_id' => fn() => Government::factory(),
            'name' => [
                'ar' => fake('ar_SA')->city,
                'en' => fake()->city,
            ],
        ];
    }
}
