<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Offer;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'category_id' => fn() => Category::factory(),
            // 'offer_id' => fn() => fake()->boolean(40) ? Offer::factory() : null,
            'name' => [
                'en' => fake()->sentence,
                'ar' => fake('ar_SA')->realText(15),
            ],
            'description' => [
                'en' => fake()->text,
                'ar' => fake('ar_SA')->realText,
            ],
            'price' => fake()->randomFloat(2, 50, 1500),
            'recommended' => fake()->boolean(30),
        ];
    }
}
