<?php


use App\Enums\User\UserStatus;
use App\Models\User;
use Inertia\Testing\AssertableInertia;

it('can search by username or name', function () {
    User::factory(3)->create();
    $user = User::factory()->create();

    $filters = [
        'search_text' => $user->name,
    ];

    $this->get(route('staff.index', $filters))
        ->assertOk()
        ->assertInertia(
            fn(AssertableInertia $page) => $page->component('Staff/Index')
                ->has('staffs.data', 1)
        );
});

it('can fitler by gender', function () {

    User::factory(3)->female()->create();

    $user = User::factory()->male()->create();

    $filters = [
        'gender' => $user->gender,
    ];

    $this->get(route('staff.index', $filters))
        ->assertOk()
        ->assertInertia(
            fn(AssertableInertia $page) => $page->component('Staff/Index')
                ->has('staffs.data', 1)
        );
});

it('can fitler by status', function () {

    User::factory(3)->female()->create();

    $user = User::factory()->status(UserStatus::INACTIVE->name)->create();

    $filters = [
        'status' => $user->status,
    ];

    $this->get(route('staff.index', $filters))
        ->assertOk()
        ->assertInertia(
            fn(AssertableInertia $page) => $page->component('Staff/Index')
                ->has('staffs.data', 1)
        );
});
