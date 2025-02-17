<?php

namespace Database\Factories;

use App\Models\ApiAccessToken;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ApiAccessTokenFactory extends Factory
{
    protected $model = ApiAccessToken::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'token' => Str::random(40),
        ];
    }

    public function expiresAt($date = null): ApiAccessTokenFactory
    {
        return $this->state(fn () => [
            'expires_at' => $date,
        ]);
    }
}
