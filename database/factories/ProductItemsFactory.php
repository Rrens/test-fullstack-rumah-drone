<?php

namespace Database\Factories;

use App\Models\ProductItems;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product_items>
 */
class ProductItemsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $last_number = ProductItems::count();
        $next_number = $last_number + 1;
        $formatted_number = sprintf('A%03d', $next_number);

        $itemTypes = [
            "Frame (rangka)",
            "Motor dan ESC (Electronic Speed Controller)",
            "Propeler",
            "Baterai",
            "Flight Controller",
            "Remote Controller (pengendali jarak jauh)",
            "GPS Modul",
            "Kamera atau Sensor",
            "Gimbal",
            "Transmitter dan Receiver",
            "Antena",
            "Landing Gear",
            "LED Lights",
            "Pengatur Daya (Voltage Regulator)",
            "Sistem FPV (First Person View)"
        ];

        $vehicleBrands = [
            "DJI (Dà-Jiāng Innovations)",
            "Parrot",
            "Yuneec",
            "Autel Robotics",
            "Skydio",
            "Hubsan",
            "Syma",
            "Holy Stone",
            "Walkera",
            "Ryze Tech (dengan DJI)",
            "PowerVision",
            "JJRC",
        ];

        $itemType = $this->faker->randomElement($itemTypes);
        $vehicleBrand = $this->faker->randomElement($vehicleBrands);

        return [
            // 'barcode' => $formatted_number,
            'name' => "$itemType $vehicleBrand",
            'category_id' => $this->faker->numberBetween(1, 10),
            'stock' => $this->faker->numberBetween(10, 100),
            'price' => $this->faker->randomFloat(2, 10000, 200000),
            'lead_time' => $this->faker->numberBetween(1, 10),
        ];
    }
}
