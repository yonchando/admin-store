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
