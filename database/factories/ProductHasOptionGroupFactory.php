<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\ProductHasOptionGroup;
use App\Models\ProductOptionGroup;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductHasOptionGroupFactory extends Factory
{
    protected $model = ProductHasOptionGroup::class;

    public function definition(): array
    {
        return [
            'is_required' => $this->faker->boolean(),
        ];
    }

    public function optionGroup($id = null): ProductHasOptionGroupFactory
    {
        return $this->state(fn () => [
            'product_option_group_id' => $id ?? ProductOptionGroup::factory()->create(),
        ]);
    }

    public function product($id = null): ProductHasOptionGroupFactory
    {
        return $this->state(fn () => [
            'product_id' => $id ?? Product::factory()->create(),
        ]);
    }
}
