<?php

namespace Database\Factories;

use App\Enums\GenderEnum;
use App\Enums\Staff\StaffStatusEnum;
use App\Models\Staff;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends Factory<Staff>
 */
class StaffFactory extends Factory
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
        $genders = GenderEnum::toJson();

        return [
            'name' => fake()->name(),
            'username' => fake()->unique()->userName(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
            'gender' => $this->faker->randomElement(array_values($genders)),
            'is_admin' => false,
            'status' => StaffStatusEnum::ACTIVE->value,
        ];
    }

    public function male(): Factory|StaffFactory
    {
        return $this->state(fn () => [
            'gender' => GenderEnum::MALE->value,
        ]);
    }

    public function female(): Factory|StaffFactory
    {
        return $this->state(fn () => [
            'gender' => GenderEnum::FEMALE->value,
        ]);
    }

    public function admin(): static
    {
        return $this->state(fn () => [
            'is_admin' => true,
        ]);
    }

    public function active(): Factory|StaffFactory
    {
        return $this->state(fn () => [
            'status' => StaffStatusEnum::ACTIVE,
        ]);
    }

    public function status($status): Factory|StaffFactory
    {
        return $this->state(fn () => [
            'status' => $status,
        ]);
    }
}
