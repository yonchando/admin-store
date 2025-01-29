<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //        Category::factory(5)->create(new Sequence(
        //            ['category_name' => 'Furniture'],
        //            ['category_name' => 'Dining Room Furniture'],
        //            ['category_name' => 'Bedroom Furniture'],
        //            ['category_name' => 'Outdoor Furniture'],
        //            ['category_name' => 'Office Furniture'],
        //            ['category_name' => 'Living Room Furniture'],
        //        ));

        Category::factory(2)->parent(11)->create();
    }
}
