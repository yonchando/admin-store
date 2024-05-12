<?php

namespace Database\Factories;

use App\Enums\Product\ProductStatus;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
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

        $file = UploadedFile::fake()->image("{$this->faker->word}.png", 40, 40);
        $path = $file->hashName(config('paths.product_image'));

        return [
            'product_name' => $name,
            'slug' => Str::slug($name),
            'description' => $this->faker->paragraphs(3, true),
            'price' => $this->faker->numberBetween(1, 100),
            'stock_quantity' => $this->faker->numberBetween(1, 1000),
            'json' => [
                'image' => [
                    'filename' => $file->hashName(),
                    'original_name' => $file->getClientOriginalName(),
                    'path' => $path,
                    'url' => Storage::url($path),
                    'extension' => $file->extension(),
                ],
            ],
            'status' => ProductStatus::ACTIVE->value,
        ];
    }

    public function active(): ProductFactory|Factory
    {
        return $this->state(fn() => [
            'status' => ProductStatus::ACTIVE->value,
        ]);
    }

    public function inactive(): ProductFactory|Factory
    {
        return $this->state(fn() => [
            'status' => ProductStatus::INACTIVE->value,
        ]);
    }

    public function category($id = null): ProductFactory|Factory
    {
        return $this->state(fn() => [
            'category_id' => $id ?? Category::factory(),
        ]);
    }
}
