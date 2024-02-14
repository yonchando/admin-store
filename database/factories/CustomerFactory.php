<?php

namespace Database\Factories;

use App\Enums\Gender;
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
        $countryCode = '+855';
        $phone = $this->faker->unique()->e164PhoneNumber;

        return [
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'phone' => $countryCode.substr($phone, $this->faker->numberBetween(4, 5)),
            'password' => Hash::make('password'),
            'email' => $this->faker->unique()->safeEmail,
            'city_id' => $province->city_id,
            'province_id' => $province->id,
            'gender' => $this->faker->randomElement(Gender::cases()),
        ];
    }
}
