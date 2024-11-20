<?php

namespace Database\Factories;

use App\Enums\Customer\CustomerStatusEnum;
use App\Enums\GenderEnum;
use App\Models\Customer;
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
        $phone = $this->faker->unique()->phoneNumber;

        return [
            'nickname' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'phone_number' => $phone,
            'password' => Hash::make('password'),
            'gender' => $this->faker->randomElement([GenderEnum::MALE, GenderEnum::FEMALE]),
            'status' => $this->faker->randomElement([CustomerStatusEnum::ACTIVE, CustomerStatusEnum::INACTIVE]),
        ];
    }
}
