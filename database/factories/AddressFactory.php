<?php

namespace Database\Factories;

use App\Models\Area;
use App\Models\City;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Address>
 */
class AddressFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        // $area = Area::factory()->create();
        return [
            'user_id' => fn() => User::factory(),
            // 'city_id' => fn() => $area->city_id,
            'area_id' => fn() => Area::factory(),
            'name' => fake()->address,
            'street' => fake()->streetName,
        ];
    }
}
