<?php

namespace Database\Factories;

use App\Models\Card;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class CardFactory extends Factory
{
    protected $model = Card::class;

    public function definition(): array
    {
        return [
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'name' => $this->faker->name(),
            'number' => $this->faker->word(),
            'expired_at' => $this->faker->word(),
            'pionts_balance' => $this->faker->word(),
            'cashback_balance' => $this->faker->word(),
        ];
    }
}
