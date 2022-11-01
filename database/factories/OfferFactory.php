<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Offer>
 */
class OfferFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'title' => [
                'en' => fake()->sentence,
                'ar' => fake()->sentence,
            ],
            'description' => [
                'en' => fake()->realText,
                'ar' => fake('ar/SA')->realText,
            ],
            'date_from' => today(),
            'date_to' => now()->addMonths(3),
            'quantity' => fake()->randomDigitNotZero(),
            'offer_value' => fake()->randomFloat(2),
        ];
    }
}
