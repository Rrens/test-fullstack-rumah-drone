<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Product_category;
use App\Models\Product_items;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            SupplierSeeder::class,
            CustomerSeeder::class,
            ProductCategorySeeder::class,
            ProductItemsSeeder::class,
            // CartSeeder::class,
            SaleSeeder::class,
            SaleDetailSeeder::class,
            HistorySeeder::class,
            // StockSeeder::class,
            PembelianSeeder::class,
            PenerimaanSeeder::class,
        ]);
    }
}
