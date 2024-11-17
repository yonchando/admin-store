<?php

namespace Database\Factories;

use App\Models\Module;
use Illuminate\Database\Eloquent\Factories\Factory;

class ModuleFactory extends Factory
{
    protected $model = Module::class;

    public function definition(): array
    {
        return [
            'code' => $this->faker->word,
            'name' => $this->faker->word,
            'status' => 'active',
        ];
    }
}
