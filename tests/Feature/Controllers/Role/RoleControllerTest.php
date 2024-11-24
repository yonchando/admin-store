<?php

use App\Enums\Role\RoleStatusEnum;
use App\Models\Module;
use App\Models\Permission;
use App\Models\Role;
use Inertia\Testing\AssertableInertia;

use function Pest\Laravel\get;
use function Pest\Laravel\post;
use function Pest\Laravel\putJson;

beforeEach(function () {
    asAdmin();
});

test('index page can get list of roles', function () {
    $roles = Role::factory(100)->create([
        'status' => RoleStatusEnum::ACTIVE->value,
    ]);

    get(route('role.index'))
        ->assertInertia(
            fn (AssertableInertia $page) => $page->component('Role/RoleIndex')
                ->has('roles')
                ->where('roles.total', $roles->count())
        );
});

test('store role', function () {
    $permissions = Permission::factory(4)->create();

    $module = Module::factory()->hasAttached($permissions)->create();
    $module1 = Module::factory()->hasAttached($permissions->take(3))->create();

    $data = [
        'code' => 'SALE',
        'name' => 'Sale',
        'status' => RoleStatusEnum::ACTIVE->value,
        'permissions' => [
            $module->id => $module->permissions->pluck('id')->toArray(),
            $module1->id => $module1->permissions->pluck('id')->toArray(),
        ],
    ];

    post(route('role.store'), $data)
        ->assertRedirectToRoute('role.index')
        ->assertSessionHas([
            'success' => __('lang.created_success', ['attribute' => __('lang.role')]),
        ]);

    $role = Role::where('code', 'SALE')->first();

    expect($role->permissions->pluck('id')->toArray())->toEqual([
        ...$permissions->pluck('id')->toArray(),
        ...$permissions->take(3)->pluck('id')->toArray(),
    ]);
});

test('update role', function () {

    $permissions = Permission::factory(4)->create();

    $module = Module::factory()->hasAttached($permissions)->create();
    $module1 = Module::factory()->hasAttached($permissions->take(3))->create();

    $first = Role::factory()->hasAttached($permissions, ['module_id' => $module->id])->create();

    $role = Role::factory()->create();

    $data = [
        'code' => 'SALE',
        'name' => 'Sale',
        'status' => RoleStatusEnum::ACTIVE->value,
        'permissions' => [
            $module1->id => $module1->permissions->pluck('id')->toArray(),
        ],
    ];

    putJson(route('role.update', $role->id), $data)
        ->assertRedirectToRoute('role.show', $role->id)
        ->assertSessionHas([
            'success' => __('lang.updated_success', ['attribute' => __('lang.role')]),
        ]);

    $role->refresh();

    expect($role->permissions)->not()->toBeEmpty()
        ->and($role->permissions->pluck('id'))->toEqual($permissions->take(3)->pluck('id'))
        ->and($first->permissions->pluck('id'))->toEqual($permissions->pluck('id'));
});
