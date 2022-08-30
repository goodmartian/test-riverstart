<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run()
    {
        $products = Product::factory(20)->create();
        $categories = Category::all();

        $products->each(function (Product $product) use ($categories) {
            $product->categories()->attach($categories);
        });
    }
}
