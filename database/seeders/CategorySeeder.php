<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        Category::insert([
            ['category_name' => 'Tires'],
            ['category_name' => 'Rims & Wheels'],
            ['category_name' => 'Batteries'],
            ['category_name' => 'Engine Oil'],
            ['category_name' => 'Accessories'],
            ['category_name' => 'Car Care'],
        ]);
    }
}
