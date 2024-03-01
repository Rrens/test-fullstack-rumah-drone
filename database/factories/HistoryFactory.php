<?php

namespace Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\History>
 */
class HistoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $date = Carbon::today();
        $last_month = Carbon::today()->subMonths(1);
        return [
            'item_id' => $this->faker->randomNumber(1, 20),
            'date' => $this->faker->dateTimeBetween($last_month, $date)->format('Y-m-d'),
            'total' => $this->faker->randomNumber(1, 10)
        ];
    }
}
