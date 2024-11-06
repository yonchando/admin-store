<?php

use App\Enums\GenderEnum;
use App\Enums\User\UserStatusEnum;
use App\Facades\Enum;
use App\Models\User;
use Inertia\Testing\AssertableInertia;

describe('user lists', function () {
    test('index methods', function () {
        $staff = User::factory(3)->create();

        $this->get(route('staff.index'))
            ->assertOk()
            ->assertInertia(
                fn (AssertableInertia $page) => $page->component('Staff/Index')
                    ->has('staffs.data', $staff->count())
                    ->has('gender', 2)
                    ->has('statuses', 2)
                    ->has('filters')
            );
    });

    test('filter user list', function () {

        User::factory()->create([
            'name' => fake()->name,
            'username' => fake()->userName,
            'gender' => fake()->randomElement(Enum::toArray(GenderEnum::cases(), true)),
            'created_at' => now()->subHours(2),
        ]);

        $first = User::factory()->create([
            'name' => fake()->name,
            'username' => fake()->userName,
            'gender' => fake()->randomElement(Enum::toArray(GenderEnum::cases(), true)),
            'created_at' => now(),
        ]);

        $filters = [
            'search_text' => $first->name,
            'gender' => $first->gender->value,
            'status' => UserStatusEnum::ACTIVE->name,
        ];

        $this->get(route('staff.index', $filters))
            ->assertOk()
            ->assertInertia(
                fn (AssertableInertia $page) => $page->component('Staff/Index')
                    ->has('staffs.data', 1)
                    ->has(
                        'staffs.data.0',
                        fn (AssertableInertia $page) => $page->where('id', $first->id)
                            ->where('name', $first->name)
                            ->where('username', $first->username)
                            ->etc()
                    )
            );
    });
});

describe('create staff', function () {
    it('create form can render', function () {
        $this->get(route('staff.create'))
            ->assertOk()
            ->assertInertia(
                fn (AssertableInertia $page) => $page->component('Staff/Form')
            );
    });

    it('can save data to database from submit form', function () {
        $user = User::factory()->make();

        $form = $user->toArray();

        $form['password'] = 'password';
        $form['password_confirmation'] = 'password';

        $this->post(route('staff.store'), $form)
            ->assertRedirect(route('staff.index'))
            ->assertSessionHas('message.text', __('lang.created_success', ['attribute' => __('lang.staff')]));

        $this->assertDatabaseHas($user->getTable(), [
            'name' => $user->name,
            'username' => $user->username,
        ]);
    });
});

describe('edit staff', function () {
    it('can render form for edition', function () {
        $user = User::factory()->create();

        $this->get(route('staff.edit', $user))
            ->assertOk()
            ->assertInertia(
                fn (AssertableInertia $page) => $page->component('Staff/Form')
                    ->where('staff.id', $user->id)
                    ->where('staff.name', $user->name)
                    ->where('staff.username', $user->username)
            );
    });

    it('can updated user data', function () {
        $user = User::factory()->create();

        $changed = User::factory()->make();

        $this->patch(route('staff.update', $user), $changed->toArray())
            ->assertRedirect(route('staff.index'))
            ->assertSessionHas('message.text', __('lang.updated_success', ['attribute' => __('lang.staff')]));

        $updated = $user->fresh();

        $this->assertEquals($changed->name, $updated->name);
        $this->assertEquals($changed->username, $updated->username);
        $this->assertEquals($changed->gender, $updated->gender);
        $this->assertEquals($updated->password, $user->password);

        $this->assertNotEquals($user->name, $updated->name);
        $this->assertNotEquals($user->username, $updated->username);

    });

    it('can update status', function () {
        $user = User::factory()->create();

        $this->patch(route('staff.update.status', $user))
            ->assertRedirect()
            ->assertSessionHas('message.text',
                __('lang.updated_success', ['attribute' => __('lang.staff').' '.__('lang.status')]));

        $user->refresh();

        $this->assertEquals(UserStatusEnum::INACTIVE, $user->status);

        $this->patch(route('staff.update.status', $user))
            ->assertRedirect()
            ->assertSessionHas('message.text',
                __('lang.updated_success', ['attribute' => __('lang.staff').' '.__('lang.status')]));

        $user->refresh();

        $this->assertEquals(UserStatusEnum::ACTIVE, $user->status);
    });
});

test('delete staff', function () {

    $staff = User::factory()->create();

    $this->from(route('staff.index'));

    $this->delete(route('staff.destroy', $staff))
        ->assertRedirect(route('staff.index'))
        ->assertSessionHas('message.text', __('lang.deleted_success', ['attribute' => __('lang.staff')]));

    $this->delete(route('staff.destroy', $staff))
        ->assertStatus(404);

});
