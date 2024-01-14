<?php

namespace Database\Factories;

use App\Enums\Gender;
use App\Facades\Helper;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends Factory<User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $genders = Helper::enumToArray(Gender::cases(), true);
        return [
            'name' => fake()->name(),
            'username' => fake()->unique()->userName(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
            'gender' => $this->faker->randomElement($genders),
            'is_admin' => false,
        ];
    }

    public function admin(): static
    {
        return $this->state(fn() => [
            'is_admin' => true,
        ]);
    }
}
