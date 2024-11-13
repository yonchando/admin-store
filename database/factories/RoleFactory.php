<?php

namespace Database\Factories;

use App\Enums\Role\RoleStatusEnum;
use App\Models\Role;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class RoleFactory extends Factory
{
    protected $model = Role::class;

    public function definition(): array
    {
        $name = $this->faker->jobTitle();

        return [
            'code' => Str::upper($name),
            'name' => $name,
            'guard_name' => $this->faker->name(),
            'status' => $this->faker->randomElement(RoleStatusEnum::toJson()),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
