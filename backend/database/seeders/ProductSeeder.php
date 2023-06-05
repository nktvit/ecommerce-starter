<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\ProductCategory;
use App\Models\Products;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = Products::factory()->count(50)->create();

        foreach ($products as $product) {
            $category = Category::inRandomOrder()->first();

            $productCategory = new ProductCategory;
            $productCategory->product_id = $product->id;
            $productCategory->category_id = $category->id;
            $productCategory->save();
        }
    }
}
