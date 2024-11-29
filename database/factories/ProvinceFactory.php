<?php

namespace Database\Factories;

use App\Models\City;
use App\Models\Province;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProvinceFactory extends Factory
{
    protected $model = Province::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'short_name' => $this->faker->name(),
            'city_id' => City::factory()->create(),
        ];
    }

    public function city($id = null): ProvinceFactory
    {
        return $this->state(fn () => [
            'city_id' => $id ?? City::factory()->create(),
        ]);
    }
}
