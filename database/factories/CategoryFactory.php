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
                'en' => $this->faker->sentence,
                'ar' => $this->faker->sentence,
            ],
            'description' => [
                'en' => $this->faker->text,
                'ar' => $this->faker->text,
            ],
            'image' => null,
        ];
    }
}
