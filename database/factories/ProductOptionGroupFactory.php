<?php

namespace Database\Factories;

use App\Models\ProductOptionGroup;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class ProductOptionGroupFactory extends Factory
{
    protected $model = ProductOptionGroup::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
        ];
    }
}
