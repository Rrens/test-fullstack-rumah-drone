<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Sale>
 */
class SaleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'invoice' => 'MP' . $this->faker->numberBetween(12123, 93290),
            'customer_id' => $this->faker->numberBetween(1, 10),
            'user_id' => 1,
            'total_price' => $this->faker->numberBetween(10000, 1000000),
            'service' => $this->faker->numberBetween(1000, 10000),
            'final_price' => $this->faker->numberBetween(10000, 1000000),
            'cash' => $this->faker->numberBetween(10000, 1000000),
            'remaining' => $this->faker->randomFloat(2, 0, 500),
            'note' => $this->faker->text,
            'date' => $this->faker->dateTimeBetween('2024-01-01', '2024-12-31')->format('Y-m-d'),
        ];
    }
}
