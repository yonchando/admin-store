<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \Storage::deleteDirectory(config('paths.product_image'));
        Product::factory(1000)->state(
            new Sequence(
                ['category_id' => null],
                ['category_id' => Category::factory()->create()->id]
            )
        )->create();
    }
}
