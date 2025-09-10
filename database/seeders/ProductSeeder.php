<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Barcode;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        \App\Models\Product::factory()
            ->count(1000)
            ->create()
            ->each(function ($product) {

                $product->barcodes()->create([
                    'code' => fake()->ean13(), 
                ]);
            });
    }
}
