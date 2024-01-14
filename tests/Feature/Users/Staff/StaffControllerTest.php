<?php


use App\Enums\Gender;
use App\Enums\User\UserStatus;
use App\Facades\Helper;
use App\Models\User;
use Inertia\Testing\AssertableInertia;


describe('user lists', function () {
    test('index methods', function () {
        $staff = User::factory(3)->create();

        $this->get(route('staff.index'))
            ->assertOk()
            ->assertInertia(
                fn(AssertableInertia $page) => $page->component('Staff/Index')
                    ->has('staffs.data', $staff->count())
            );
    });

    test('filter user list', function () {

        User::factory()->create([
            'name' => fake()->name,
            'username' => fake()->userName,
            'gender' => fake()->randomElement(Helper::enumToArray(Gender::cases())),
            'created_at' => now()->subHours(2),
        ]);

        $first = User::factory()->create([
            'name' => fake()->name,
            'username' => fake()->userName,
            'gender' => fake()->randomElement(Helper::enumToArray(Gender::cases())),
            'created_at' => now(),
        ]);

        $filters = [
            'search_text' => $first->name,
            'status' => UserStatus::ACTIVE->name,
        ];

        $this->get(route('staff.index', $filters))
            ->assertOk()
            ->assertInertia(
                fn(AssertableInertia $page) => $page->component('Staff/Index')
                    ->has('staffs.data', 1)
                    ->has(
                        'staffs.data.0',
                        fn(AssertableInertia $page) => $page->where('id', $first->id)
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
                fn(AssertableInertia $page) => $page->component('Staff/Form')
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

test('delete staff', function () {

    $staff = User::factory()->create();

    $this->from(route('staff.index'));

    $this->delete(route('staff.destroy', $staff))
        ->assertRedirect(route('staff.index'));

    $this->delete(route('staff.destroy', $staff))
        ->assertStatus(404);

});