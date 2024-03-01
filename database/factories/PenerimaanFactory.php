<?php

namespace Database\Factories;

use App\Models\Pembelian;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Penerimaan>
 */
class PenerimaanFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $array_pembelian = array();
        foreach (Pembelian::all() as $item) {
            array_push($array_pembelian, $item->id);
        }
        return [
            'pembelian_id' => Arr::random($array_pembelian),
            'jumlah_penerimaan' => $this->faker->numberBetween(1, 300),
            'tanggal_penerimaan' => $this->faker->dateTimeBetween('2023-12-12', '2023-12-30')->format('Y-m-d'),
        ];
    }
}
