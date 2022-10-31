<?php

namespace Database\Factories;

use App\Models\Address;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $statesArray = ['pending', 'rejected', 'in-progress', 'completed', 'canceled'];
        $serviceTypesArray = ['takeaway', 'delivery'];

        $subTotal = fake()->randomFloat(2, 5, 500.2);
        $taxes = fake()->randomDigitNotZero();
        $delivery_fees = fake()->randomFloat(2, 0, 30);
        $total = $subTotal + $delivery_fees + $subTotal;
        return [
            'user_id' => fn() => User::factory(),
            'address_id' => fn() => Address::factory(),
            'subTotal' => $subTotal,
            'taxes' => $taxes,
            'delivery_fees' => $delivery_fees,
            'total' => $total,
        ];
    }
}
