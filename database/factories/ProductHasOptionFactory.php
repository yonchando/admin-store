<?php

namespace Database\Factories;

use App\Models\ProductHasOption;
use App\Models\ProductHasOptionGroup;
use App\Models\ProductOption;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class ProductHasOptionFactory extends Factory
{
    protected $model = ProductHasOption::class;

    public function definition(): array
    {
        return [
            'price_adjustment' => $this->faker->randomFloat(2, 0, 10),
            'product_has_option_group_id' => ProductHasOptionGroup::factory(),
            'product_option_id' => ProductOption::factory(),
        ];
    }

    public function hasGroupId($id = null): ProductHasOptionFactory
    {
        return $this->state(fn() => [
            'product_has_option_group_id' => $id ?? ProductHasOptionGroup::factory(),
        ]);
    }

    public function option($id = null): ProductHasOptionFactory
    {
        return $this->state(fn() => [
            'product_option_id' => $id ?? ProductOption::factory(),
        ]);
    }
}
