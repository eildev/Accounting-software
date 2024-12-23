<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'id' => 1,
                'name' => 'Clothing',
                'slug' => 'clothing',
            ],
            [
                'id' => 2,
                'name' => 'Electronics',
                'slug' => 'electronics',
            ],
            [
                'id' => 3,
                'name' => 'Food',
                'slug' => 'food',
            ],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
