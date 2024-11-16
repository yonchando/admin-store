<?php

use App\Enums\Staff\StaffStatusEnum;
use App\Models\Staff;
use Inertia\Testing\AssertableInertia;

it('can search by username or name', function () {
    Staff::factory(3)->create();
    $user = Staff::factory()->create();

    $filters = [
        'search_text' => $user->name,
    ];

    $this->get(route('staff.index', $filters))
        ->assertOk()
        ->assertInertia(
            fn (AssertableInertia $page) => $page->component('Staff/Index')
                ->has('staffs.data', 1)
        );
});

it('can filter by gender', function () {

    Staff::factory(3)->female()->create();

    $user = Staff::factory()->male()->create();

    $filters = [
        'gender' => $user->gender,
    ];

    $this->get(route('staff.index', $filters))
        ->assertOk()
        ->assertInertia(
            fn (AssertableInertia $page) => $page->component('Staff/Index')
                ->has('staffs.data', 1)
        );
});

it('can filter by status', function () {

    Staff::factory(3)->female()->create();

    $user = Staff::factory()->status(StaffStatusEnum::INACTIVE->name)->create();

    $filters = [
        'status' => $user->status,
    ];

    $this->get(route('staff.index', $filters))
        ->assertOk()
        ->assertInertia(
            fn (AssertableInertia $page) => $page->component('Staff/Index')
                ->has('staffs.data', 1)
        );
});
