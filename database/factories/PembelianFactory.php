<?php

namespace Database\Factories;

use App\Models\ProductItems;
use App\Models\Supplier;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pembelian>
 */
class PembelianFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $array_supplier = array();
        foreach (Supplier::all() as $item) {
            array_push($array_supplier, $item->id);
        }

        $array_item = array();
        foreach (ProductItems::all() as $item) {
            array_push($array_item, $item->id);
        }

        return [
            'jumlah_pembelian' => $this->faker->numberBetween(20, 20000),
            'supplier_id' => Arr::random($array_supplier),
            'item_id' => Arr::random($array_item),
            'tanggal_pembelian' => $this->faker->dateTimeBetween('2023-12-12', '2023-12-30')->format('Y-m-d'),
        ];
    }
}
