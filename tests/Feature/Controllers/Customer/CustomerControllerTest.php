<?php

use App\Models\Customer;
use Inertia\Testing\AssertableInertia;

use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\getJson;
use function Pest\Laravel\postJson;
use function Pest\Laravel\putJson;

beforeEach(function () {
    asUser();
});

test('customer listing', function () {

    $customers = Customer::factory(3)->create();

    getJson(route('customer.index'))
        ->assertOk()
        ->assertInertia(
            fn (AssertableInertia $page) => $page->component('Customer/CustomerIndex')
                ->has('customers.data', $customers->count())
        );
});

test('customer create form', function () {
    getJson(route('customer.create'))
        ->assertInertia(
            fn (AssertableInertia $page) => $page->component('Customer/CustomerForm')
        );
});

test('customer store', function () {
    $customer = Customer::factory()->make();

    $data = $customer->toArray();

    $data['password'] = 'password';
    $data['password_confirmation'] = 'password';

    postJson(route('customer.store'), $data)
        ->assertRedirectToRoute('customer.index');

    assertDatabaseHas(Customer::class, [
        'phone_number' => $customer->phone_number,
    ]);
});

test('edit customer form', function () {
    $customer = Customer::factory()->create();

    $this->get(route('customer.edit', $customer->id))
        ->assertOk()
        ->assertInertia(
            fn (AssertableInertia $page) => $page->component('Customer/CustomerForm')
                ->where('customer.id', $customer->id)
                ->where('customer.phone_number', $customer->phone_number)
        );
});

test('customer update', function () {
    $customer = Customer::factory()->create();

    $data = $customer->toArray();

    $data['nickname'] = fake()->name;
    $data['password'] = 'update-password';
    $data['password_confirmation'] = 'update-password';

    putJson(route('customer.update', $customer->id), $data)
        ->assertRedirectToRoute('customer.index');

});

test('show customer detail', function () {
    $customer = Customer::factory()->create();

    $this->get(route('customer.show', $customer->id))
        ->assertOk()
        ->assertInertia(
            fn (AssertableInertia $page) => $page->component('Customer/CustomerShow')
                ->where('customer.id', $customer->id)
                ->where('customer.phone_number', $customer->phone_number)
        );
});
