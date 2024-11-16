<?php

namespace Database\Factories;

use App\Enums\Role\RoleStatusEnum;
use App\Models\Module;
use App\Models\Role;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class RoleFactory extends Factory
{
    protected $model = Role::class;

    public function definition(): array
    {
        $name = $this->faker->jobTitle();

        return [
            'code' => $name,
            'name' => $name,
            'guard_name' => $this->faker->name(),
            'status' => $this->faker->randomElement(RoleStatusEnum::toJson()),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }

    public function givePermissions(Module $module): RoleFactory
    {
        return $this->hasAttached($module->permissions, ['module_id' => $module->id]);
    }

    public function active(): static
    {
        return $this->state(fn () => [
            'status' => RoleStatusEnum::ACTIVE->value,
        ]);
    }
}
