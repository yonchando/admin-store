<?php

namespace Database\Factories;

use App\Enums\Product\ProductStatus;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Str;

/**
 * @extends Factory<Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = $this->faker->unique()->name;
        return [
            'product_name' => $name,
            'category_id' => null,
            'slug' => Str::slug($name),
            'description' => $this->faker->paragraphs(3, true),
            'price' => $this->faker->numberBetween(1, 100),
            'stock_quantity' => $this->faker->numberBetween(1, 1000),
            'image' => $this->faker->imageUrl,
            'json' => null,
            'status' => ProductStatus::ACTIVE->name,
        ];
    }

    public function active(): ProductFactory|Factory
    {
        return $this->state(fn() => [
            'status' => ProductStatus::ACTIVE->name,
        ]);
    }

    public function inactive(): ProductFactory|Factory
    {
        return $this->state(fn() => [
            'status' => ProductStatus::INACTIVE->name,
        ]);
    }

    public function category($id = null): ProductFactory|Factory
    {
        return $this->state(fn() => [
            'category_id' => $id ?? Category::factory(),
        ]);
    }
}
