<?php

namespace Database\Factories;

use App\Models\Card;
use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class CardFactory extends Factory
{
    protected $model = Card::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
        ];
    }
}
