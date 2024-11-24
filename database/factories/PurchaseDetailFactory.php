<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\PurchaseDetail;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<PurchaseDetail>
 */
class PurchaseDetailFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $product = Product::inRandomOrder()->first();
        $qty = $this->faker->numberBetween(1, 10);

        return [
            'ref_product_id' => $product->id,
            'product_name' => $product->product_name,
            'category_name' => $product->category?->category_name,
            'price' => $product->price,
            'qty' => $qty,
            'sub_total' => $product->price * $qty,
        ];
    }
}
