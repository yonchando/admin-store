<?php

namespace Database\Factories;

use App\Models\OrderItem;
use App\Models\PurchaseOrder;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<OrderItem>
 */
class OrderItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $qty = $this->faker->numberBetween(1, 10);
        $product_price = $this->faker->randomFloat(2, 10, 100);
        return [
            'purchase_order_id' => PurchaseOrder::factory(),
            'product_name' => $this->faker->unique()->name,
            'product_price' => $product_price,
            'qty' => $qty,
            'total_price' => $product_price * $qty,
        ];
    }
}
