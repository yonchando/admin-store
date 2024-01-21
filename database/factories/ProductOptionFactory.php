<?php

namespace Database\Factories;

use App\Models\ProductOption;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class ProductOptionFactory extends Factory
{
    protected $model = ProductOption::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'price_adjustment' => $this->faker->randomFloat(2, 1, 10),
        ];
    }
}
