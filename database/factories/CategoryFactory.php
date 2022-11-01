<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => [
                'en' => $this->faker->text(10),
                'ar' => fake('ar_SA')->realText(15),
            ],
            'description' => [
                'en' => $this->faker->text,
                'ar' => fake('ar_SA')->realText,
            ],
            'image' => null,
        ];
    }
}
