<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Stock>
 */
class StockFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'item_id' => $this->faker->randomNumber(1, 20),
            'supplier_id' => $this->faker->randomNumber(1, 10),
            'user_id' => 1,
            'quantity' => $this->faker->randomNumber(1, 5),
            'date' => $this->faker->dateTimeThisMonth,
            'type' => $this->faker->randomElement(['in', 'out']),
        ];
    }
}
