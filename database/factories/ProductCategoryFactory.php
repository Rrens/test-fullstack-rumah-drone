<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product_category>
 */
class ProductCategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $vehicleParts = ['Oli', 'Kampas Rem', 'Seal', 'Lampu', 'Filter Udara', 'Busi', 'Aki', 'Wiper', 'Radiator', 'Pompa Bensin', 'Bearing', 'Karburator', 'Koil', 'Saklar Lampu', 'Starter', 'Kabel Busi', 'Master Cylinder', 'Radiator Hose', 'Thermostat', 'Sensor Oksigen'];

        return [
            'name' => $this->faker->unique()->randomElement($vehicleParts),
        ];
    }
}
