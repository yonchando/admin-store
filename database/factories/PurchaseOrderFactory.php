<?php

namespace Database\Factories;

use App\Enums\PurchaseOrder\PurchaseOrderStatus;
use App\Models\Customer;
use App\Models\PurchaseOrder;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<PurchaseOrder>
 */
class PurchaseOrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'transaction_id' => \Str::upper($this->faker->unique()->word),
            'total_price' => $this->faker->randomFloat(2, 10, 100),
            'status' => PurchaseOrderStatus::PENDING->name,
            'purchased_at' => $this->faker->dateTimeBetween('-30 months', '-1 week')->format('Y-m-d H:i:s'),
        ];
    }

    public function customer($id = null): PurchaseOrderFactory|Factory
    {
        return $this->state(fn() => [
            'customer_id' => $id ?? Customer::factory(),
        ]);
    }

    public function purchasedAt($date = null): PurchaseOrderFactory|Factory
    {
        return $this->state(fn() => [
            'purchased_at' => $date ?? now()->toDateTimeString(),
        ]);
    }
}
