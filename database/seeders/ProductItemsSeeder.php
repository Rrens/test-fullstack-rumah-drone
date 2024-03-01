<?php

namespace Database\Seeders;

use App\Models\ProductItems;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as FakerFactory;
use Illuminate\Support\Facades\DB;

class ProductItemsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    protected $faker;

    public function __construct(FakerFactory $faker)
    {
        // parent::__construct();
        $this->faker = FakerFactory::create();
    }

    public function run(): void
    {
        // ProductItems::factory(20)->create();
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

        foreach (range(1, 10) as $i) {
            $itemType = $itemTypes[array_rand($itemTypes)];
            $vehicleBrand = $vehicleBrands[array_rand($vehicleBrands)];
            $last_number = ProductItems::count();
            $next_number = $last_number + 1;
            $formatted_number = sprintf('A%03d', $next_number);

            DB::table('product_items')->insert([
                'barcode' => $formatted_number,
                'category_id' => $this->faker->numberBetween(1, 10),
                'name' => "$itemType $vehicleBrand",
                'stock' => $this->faker->numberBetween(10, 100),
                'price' => $this->faker->randomFloat(2, 10000, 200000),
            ]);
        }
    }
}
