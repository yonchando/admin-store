<?php

namespace Database\Factories;

use App\Models\Category\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Str;

/**
 * @extends Factory<Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = $this->faker->name;

        return [
            'category_name' => $name,
            'slug' => Str::slug($name),
        ];
    }
}
