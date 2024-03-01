<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SaleDetail>
 */
class SaleDetailFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'sale_id' => $this->faker->randomNumber(1, 20),
            'item_id' => $this->faker->randomNumber(1, 20),
            'price' => $this->faker->randomFloat(2, 1000, 10000),
            'qty' => $this->faker->randomNumber(1, 10),
            'discount_item' => $this->faker->randomFloat(2, 1000, 5000),
            'total' => $this->faker->randomFloat(2, 100000, 10000000),
        ];
    }
}
