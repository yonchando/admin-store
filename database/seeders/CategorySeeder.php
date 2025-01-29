<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'category_name' => 'Furniture',
                'children' => [
                    [
                        'category_name' => 'Bedroom Furniture',
                        'children' => [
                            ['category_name' => 'Mattresses'], ['category_name' => 'Open Closets'],
                            ['category_name' => 'Headboards'], ['category_name' => 'Dressers'],
                            ['category_name' => 'Chaise Lounges'], ['category_name' => 'Nightstands'],
                        ],
                    ],
                    [
                        'category_name' => 'Living Room Furniture',
                        'children' => [
                            ['category_name' => 'Living Room Sofas'], ['category_name' => 'Living Room Chairs'],
                            ['category_name' => 'CD Racks'], ['category_name' => 'Living Room Cabinets'],
                            ['category_name' => 'Coffee Tables'], ['category_name' => 'End Tables'],
                        ],
                    ],
                    [
                        'category_name' => 'Outdoor Furniture',
                        'children' => [
                            ['category_name' => 'Garden Furniture Sets'],
                            ['category_name' => 'Patio Umbrellas & Bases'], ['category_name' => 'Waiting Chairs'],
                            ['category_name' => 'Beach Chairs'], ['category_name' => 'Hammocks'],
                            ['category_name' => 'Sun Loungers'],
                        ],
                    ],
                    [
                        'category_name' => 'Office Furniture',
                        'children' => [
                            ['category_name' => 'Filing Cabinets'], ['category_name' => 'Conference Tables'],
                            ['category_name' => "Children's Bookcases"], ['category_name' => 'Computer Desks'],
                            ['category_name' => 'Office Chairs'],
                        ],
                    ],
                    [
                        'category_name' => 'Dining Room Furniture',
                        'children' => [
                            ['category_name' => 'Restaurant Tables'], ['category_name' => 'Dining Room Sets'],
                            ['category_name' => 'Bar Stools'], ['category_name' => 'Dining Chairs'],
                            ['category_name' => 'Bar Tables'], ['category_name' => 'Dining Tables'],
                        ],
                    ],
                ],
            ],
        ];

        $this->storeData($categories);
    }

    protected function storeData($data, $parentId = null): void
    {
        foreach ($data as $category) {
            $item = Category::create([
                'category_name' => $category['category_name'],
                'slug' => Str::slug($category['category_name']),
                'parent_id' => $parentId,
            ]);

            if (count(___($category, 'children', []))) {
                $this->storeData(___($category, 'children', []), $item->id);
            }
        }
    }
}
