<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Cart>
 */
class CartFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $discount = [
            0,
            $this->faker->randomFloat(2, 1000, 5000)
        ];
        return [
            'item_id' => $this->faker->randomNumber(1, 1, 20),
            'user_id' => 1,
            'price' => $this->faker->numberBetween(10000, 1000000),
            'discount_item' => Arr::random($discount),
            'total' => $this->faker->numberBetween(10000, 1000000),
            'quantity' => $this->faker->numberBetween(1, 12),
            'jumlah_jual' => $this->faker->numberBetween(1, 12),
        ];
    }
}
