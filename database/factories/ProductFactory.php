<?php

namespace Database\Factories;

use App\Enums\Product\ProductStatusEnum;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

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
            'slug' => Str::slug($name),
            'description' => $this->faker->paragraphs(3, true),
            'price' => $this->faker->numberBetween(1, 100),
            'stock_qty' => $this->faker->numberBetween(1, 1000),
            'category_id' => Category::inRandomOrder()->first()?->id,
            'json' => [],
            'status' => ProductStatusEnum::ACTIVE->value,
            'created_at' => $this->faker->dateTimeBetween('-2 months')->format('Y-m-d H:i:s'),
        ];
    }

    public function active(): ProductFactory|Factory
    {
        return $this->state(fn () => [
            'status' => ProductStatusEnum::ACTIVE->value,
        ]);
    }

    public function inactive(): ProductFactory|Factory
    {
        return $this->state(fn () => [
            'status' => ProductStatusEnum::INACTIVE->value,
        ]);
    }

    public function category($id = null): ProductFactory|Factory
    {
        return $this->state(fn () => [
            'category_id' => $id ?? Category::factory(),
        ]);
    }
}
