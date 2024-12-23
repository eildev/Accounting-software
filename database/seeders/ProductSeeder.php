<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            [
                'id' => 1,
                'name' => 'OnePlus Foldable Phones Model 974',
                'branch_id' => 1,
                'barcode' => '000000000001',
                'category_id' => 1, // Consumer Electronics
                'subcategory_id' => 1, // Smartphones
                'brand_id' => 1, // Apple
                'cost' => 240,
                'price' => 300,
                'details' => 'OnePlus Foldable Phones Model 974 features a sleek design, powerful A15 Bionic chip, and advanced camera system.',
                'image' => null,
                'main_unit_stock' => 0,
                'total_sold' => 0,
                'color' => null,
                'size_id' => null,
                'unit_id' => 1,
            ],
            [
                'id' => 2,
                'name' => 'Samsung Galaxy S23',
                'branch_id' => 1,
                'barcode' => '000000000002',
                'category_id' => 1, // Consumer Electronics
                'subcategory_id' => 1, // Smartphones
                'brand_id' => 2, // Samsung
                'cost' => 250,
                'price' => 320,
                'details' => 'Samsung Galaxy S23 offers an incredible display, powerful performance, and a versatile camera setup.',
                'image' => null,
                'main_unit_stock' => 0,
                'total_sold' => 0,
                'color' => null,
                'size_id' => null,
                'unit_id' => 1,
            ],
            [
                'id' => 3,
                'name' => 'Sony PlayStation 5',
                'branch_id' => 1,
                'barcode' => '000000000003',
                'category_id' => 1, // Gaming
                'subcategory_id' => 1, // Gaming Consoles
                'brand_id' => 3, // Sony
                'cost' => 500,
                'price' => 600,
                'details' => 'Sony PlayStation 5 offers cutting-edge graphics, fast load times, and an immersive gaming experience.',
                'image' => null,
                'main_unit_stock' => 0,
                'total_sold' => 0,
                'color' => null,
                'size_id' => null,
                'unit_id' => 1,
            ],
            [
                'id' => 4,
                'name' => 'LG OLED TV C1',
                'branch_id' => 1,
                'barcode' => '000000000004',
                'category_id' => 1, // Audio/Video Equipment
                'subcategory_id' => 1, // Home Theater Systems
                'brand_id' => 2, // LG
                'cost' => 1200,
                'price' => 1500,
                'details' => 'LG OLED TV C1 provides stunning picture quality with deep blacks and vibrant colors for an exceptional viewing experience.',
                'image' => null,
                'main_unit_stock' => 0,
                'total_sold' => 0,
                'color' => null,
                'size_id' => null,
                'unit_id' => 1,
            ],
            [
                'id' => 5,
                'name' => 'Dell XPS 13',
                'branch_id' => 1,
                'barcode' => '000000000005',
                'category_id' => 1, // Computing Devices
                'subcategory_id' => 2, // Laptops
                'brand_id' => 2, // Dell
                'cost' => 900,
                'price' => 1100,
                'details' => 'Dell XPS 13 is a compact and powerful laptop with a sleek design and high-performance components.',
                'image' => null,
                'main_unit_stock' => 0,
                'total_sold' => 0,
                'color' => null,
                'size_id' => null,
                'unit_id' => 1,
            ],
            [
                'id' => 6,
                'name' => 'HP Spectre x360',
                'branch_id' => 1,
                'barcode' => '000000000006',
                'category_id' => 1, // Computing Devices
                'subcategory_id' => 2, // Laptops
                'brand_id' => 1, // HP
                'cost' => 950,
                'price' => 1200,
                'details' => 'HP Spectre x360 offers versatility with a convertible design and powerful performance for all computing needs.',
                'image' => null,
                'main_unit_stock' => 0,
                'total_sold' => 0,
                'color' => null,
                'size_id' => null,
                'unit_id' => 1,
            ],
            [
                'id' => 7,
                'name' => 'Lenovo ThinkPad X1 Carbon',
                'branch_id' => 1,
                'barcode' => '000000000007',
                'category_id' => 1, // Computing Devices
                'subcategory_id' => 2, // Laptops
                'brand_id' => 3, // Lenovo
                'cost' => 1000,
                'price' => 1300,
                'details' => 'Lenovo ThinkPad X1 Carbon is known for its durability, high-performance, and excellent keyboard for professionals.',
                'image' => null,
                'main_unit_stock' => 0,
                'total_sold' => 0,
                'color' => null,
                'size_id' => null,
                'unit_id' => 1,
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
