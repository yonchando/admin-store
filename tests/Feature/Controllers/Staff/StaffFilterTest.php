<?php

use App\Enums\Staff\StaffStatusEnum;
use App\Models\Staff;
use Inertia\Testing\AssertableInertia;

beforeEach(function () {
    asUser();
});

it('can search by username or name', function () {
    Staff::factory(3)->create();
    $user = Staff::factory()->create();

    $filters = [
        'search' => $user->name,
    ];

    $this->get(route('staff.index', $filters))
        ->assertOk()
        ->assertInertia(
            fn (AssertableInertia $page) => $page->component('Staff/StaffIndex')
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
            fn (AssertableInertia $page) => $page->component('Staff/StaffIndex')
                ->has('staffs.data', 1)
        );
});

it('can filter by status', function () {

    Staff::factory(3)->active()->create();

    $inactives = Staff::factory(2)->status(StaffStatusEnum::INACTIVE)->create();

    $filters = [
        'status' => StaffStatusEnum::INACTIVE->value,
    ];

    $this->get(route('staff.index', $filters))
        ->assertOk()
        ->assertInertia(
            fn (AssertableInertia $page) => $page->component('Staff/StaffIndex')
                ->has('staffs.data', $inactives->count())
        );
});
