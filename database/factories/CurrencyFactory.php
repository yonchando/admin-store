<?php

namespace Database\Factories;

use App\Models\Currency;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class CurrencyFactory extends Factory
{
    protected $model = Currency::class;

    public function definition(): array
    {
        $code = $this->faker->unique()->currencyCode;
        return [
            'code' => $code,
            'name' => $code,
            'symbol' => null,
            'exchange_rate' => $this->faker->randomFloat(4, 0, 1000),
        ];
    }
}
