<?php

namespace Database\Factories;

use App\Models\Currency;
use Illuminate\Database\Eloquent\Factories\Factory;

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
        ];
    }
}
