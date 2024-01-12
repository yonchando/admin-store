<?php

namespace Database\Factories;

use App\Models\Customer;
use App\Models\Province;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

/**
 * @extends Factory<Customer>
 */
class CustomerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $province = Province::factory()->create();

        return [
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'username' => $this->faker->unique()->userName,
            'password' => Hash::make('password'),
            'email' => $this->faker->unique()->safeEmail,
            'city_id' => $province->city_id,
            'province_id' => Province::factory()->create(),
        ];
    }
}
