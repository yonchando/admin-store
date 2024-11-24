<?php

namespace Database\Factories;

use App\Enums\Order\PurchaseStatusEnum;
use App\Models\Customer;
use App\Models\Purchase;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Purchase>
 */
class PurchaseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'ref_no' => Str::random(),
            'total' => $this->faker->randomFloat(2, 10, 100),
            'status' => $this->faker->randomElement(array_values(PurchaseStatusEnum::toJson())),
            'customer_id' => Customer::inRandomOrder()->first()?->id ?? Customer::factory(),
            'created_at' => $this->faker->dateTimeBetween('-3 months'),
            'purchased_at' => now()->toDateTimeString(),
        ];
    }

    public function customer($id = null): PurchaseFactory|Factory
    {
        return $this->state(fn () => [
            'customer_id' => $id ?? Customer::factory(),
        ]);
    }
}
