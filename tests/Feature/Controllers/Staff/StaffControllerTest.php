<?php

use App\Enums\Staff\StaffStatusEnum;
use App\Models\Module;
use App\Models\Permission;
use App\Models\Role;
use App\Models\Staff;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Inertia\Testing\AssertableInertia;

use function Pest\Laravel\assertSoftDeleted;
use function Pest\Laravel\get;
use function Pest\Laravel\put;

beforeEach(function () {
    asAdmin();
});

describe('user lists', function () {
    test('index methods', function () {
        $staff = Staff::factory(50)->create();

        get(route('staff.index'))
            ->assertOk()
            ->assertInertia(
                function (AssertableInertia $page) use ($staff) {
                    return $page->component('Staff/StaffIndex')
                        ->where('staffs.total', $staff->count())
                        ->has('staffs.data', $staff->take(20)->count())
                        ->has('gender', 2)
                        ->has('statuses', 2)
                        ->has('requests');
                }
            );
    });
});

describe('create staff', function () {
    it('create form can render', function () {
        $this->get(route('staff.create'))
            ->assertOk()
            ->assertInertia(
                fn (AssertableInertia $page) => $page->component('Staff/StaffForm')
            );
    });

    it('can save staff data to database from submit form', function () {
        $user = Staff::factory()->make();

        $form = $user->toArray();

        $form['password'] = 'password';
        $form['password_confirmation'] = 'password';
        $form['status'] = StaffStatusEnum::ACTIVE->value;

        $this->post(route('staff.store'), $form)
            ->assertRedirect(route('staff.index'))
            ->assertSessionHas('success', __('lang.created_success', ['attribute' => __('lang.staff')]));

        $this->assertDatabaseHas(Staff::class, [
            'name' => $user->name,
            'username' => $user->username,
        ]);
    });

    it('can create staff with role and permission', function () {
        $permissions = initPermissions();
        $other = Module::factory()->create();
        Role::factory()->hasAttached($permissions, ['module_id' => $other->id])->create();

        $user = Staff::factory()->make([
            'username' => 'user',
        ]);

        $module = Module::factory()
            ->hasAttached($permissions)
            ->create([
                'name' => 'User',
            ]);
        $role = Role::factory()
            ->hasAttached($permissions->whereIn('code', ['READ', 'CREATE']), ['module_id' => $module->id])
            ->active()
            ->create();

        $roleOther = Role::factory()
            ->hasAttached($permissions->whereIn('code', ['READ', 'CREATE']), ['module_id' => $other->id])
            ->active()
            ->create();

        $form = $user->toArray();
        $form['password'] = 'password';
        $form['password_confirmation'] = 'password';
        $form['status'] = StaffStatusEnum::ACTIVE->value;
        $form['role_ids'] = [$role->id, $roleOther->id];
        $form['permission_ids'] = [
            $module->id => $permissions->whereIn('code', ['READ', 'CREATE', 'UPDATE', 'DELETE'])
                ->pluck('id')
                ->toArray(),
            $other->id => $permissions->whereIn('code', ['READ', 'CREATE', 'DELETE'])->pluck('id')->toArray(),
        ];

        $this->post(route('staff.store'), $form)
            ->assertRedirect(route('staff.index'))
            ->assertSessionHas('success', __('lang.created_success', ['attribute' => __('lang.staff')]));

        $staff = Staff::where('username', 'user')->first();

        expect($staff)->not()->toBeNull()
            ->and($staff->roles->pluck('id')->toArray())->toEqual($form['role_ids'])
            ->and($staff->permissions->pluck('id')->toArray())
            ->toBe([
                ...$permissions->whereIn('code', ['UPDATE', 'DELETE'])->pluck('id')->toArray(),
                ...$permissions->whereIn('code', ['DELETE'])->pluck('id')->toArray(),
            ]);
    });
});

describe('edit staff', function () {
    it('can render form for edition', function () {
        $staff = Staff::factory()->create();

        $this->get(route('staff.edit', $staff))
            ->assertOk()
            ->assertInertia(
                fn (AssertableInertia $page) => $page->component('Staff/StaffForm')
                    ->where('staff.id', $staff->id)
                    ->where('staff.name', $staff->name)
                    ->where('staff.username', $staff->username)
            );
    });

    it('can updated user data', function () {
        $staff = Staff::factory()->create();

        $changed = Staff::factory()->make();

        put(route('staff.update', $staff), $changed->toArray())
            ->assertRedirect(route('staff.index'))
            ->assertSessionHas('success', __('lang.updated_success', ['attribute' => __('lang.staff')]));

        $updated = $staff->fresh();

        $this->assertEquals($changed->name, $updated->name);
        $this->assertEquals($changed->username, $updated->username);
        $this->assertEquals($changed->gender, $updated->gender);
        $this->assertEquals($updated->password, $staff->password);

        $this->assertNotEquals($staff->name, $updated->name);
        $this->assertNotEquals($staff->username, $updated->username);
    });

    it('can updated user permissions and roles', function () {
        $permissions = initPermissions();
        $module = Module::factory()->hasAttached($permissions)->create(['name' => 'Staff']);
        $role = Role::factory()->givePermissions($module)->create(['code' => 'user']);
        $staff = Staff::factory()->create();
        $staff->assignRole([$role->id]);
        $staff->givePermissionTo(Module::factory()->create()->id, Permission::factory(2)
            ->create(
                new Sequence(
                    ['code' => 'VIEW'],
                    ['code' => 'CREATE']
                )
            ));

        $moduleRole = Module::factory()->create(['name' => 'Role']);
        $roleUpdated = Role::factory()
            ->hasAttached($permissions->take(2), ['module_id' => $moduleRole->id])
            ->create(['code' => 'admin']);
        $permissions = Permission::factory(2)
            ->create(new Sequence(
                ['code' => 'READ'],
                ['code' => 'UPDATE']
            ));
        $data = [
            'name' => $staff->name,
            'username' => $staff->username,
            'role_ids' => [$roleUpdated->id],
            'permission_ids' => [
                $module->id => $permissions->pluck('id')->toArray(),
            ],
        ];

        put(route('staff.update', $staff), $data)
            ->assertRedirect(route('staff.index'))
            ->assertSessionHas('success', __('lang.updated_success', ['attribute' => __('lang.staff')]));

        $updated = $staff->fresh();

        $perms = $updated->permissions->groupBy('module.module_id')->map(fn ($item) => $item->pluck('id'));

        expect($perms->toArray())->toEqual([
            $module->id => $permissions->pluck('id')->toArray(),
        ])->and($updated->roles->pluck('id')->toArray())->toEqual([$roleUpdated->id]);
    });
});

test('delete staff', function () {
    $staff = Staff::factory()->create();

    $this->from(route('staff.index'));

    $this->delete(route('staff.destroy'), [
        'ids' => [$staff->id],
    ])->assertRedirect(route('staff.index'))
        ->assertSessionHas('success', __('lang.deleted_success', ['attribute' => __('lang.staff')]));

    assertSoftDeleted($staff);
});
