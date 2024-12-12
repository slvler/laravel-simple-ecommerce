<?php

namespace Database\Seeders;

use App\Enums\ProductStatus;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        Product::create([
            'name' => 'item',
            'slug' => Str::slug('item'),
            'price' => rand(10,1000),
            'stock' => 100,
            'status' => ProductStatus::ACTIVE->name
        ]);

        Product::create([
            'name' => 'item-2',
            'slug' => Str::slug('item-2'),
            'price' => rand(10,1000),
            'stock' => 70,
            'status' => ProductStatus::ACTIVE->name
        ]);

        Product::create([
            'name' => 'item-3',
            'slug' => Str::slug('item-3'),
            'price' => rand(10,1000),
            'stock' => 50,
            'status' => ProductStatus::ACTIVE->name
        ]);

        Product::create([
            'name' => 'item-4',
            'slug' => Str::slug('item-4'),
            'price' => rand(10,1000),
            'stock' => 25,
            'status' => ProductStatus::ACTIVE->name
        ]);
    }
}
