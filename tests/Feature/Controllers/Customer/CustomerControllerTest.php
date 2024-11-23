<?php

use App\Models\Customer;
use Illuminate\Http\UploadedFile;
use Inertia\Testing\AssertableInertia;

use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\assertSoftDeleted;
use function Pest\Laravel\deleteJson;
use function Pest\Laravel\getJson;
use function Pest\Laravel\postJson;
use function Pest\Laravel\putJson;

beforeEach(function () {
    asAdmin();
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
    Storage::fake('public');
    $customer = Customer::factory()->make();

    $file = UploadedFile::fake()->image('image.jpg');

    $data = $customer->toArray();
    $data['password'] = 'password';
    $data['password_confirmation'] = 'password';
    $data['profile'] = $file;

    postJson(route('customer.store'), $data)
        ->assertRedirectToRoute('customer.index');

    assertDatabaseHas(Customer::class, [
        'phone_number' => $customer->phone_number,
    ]);

    Storage::disk('public')->assertExists(config('paths.customer_profile').'/'.$file->hashName());
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
    Storage::fake('public');
    $customer = Customer::factory()->create();

    $file = UploadedFile::fake()->image('image.png');

    $data = $customer->toArray();
    $data['nickname'] = fake()->name;
    $data['password'] = 'update-password';
    $data['password_confirmation'] = 'update-password';
    $data['profile'] = $file;

    putJson(route('customer.update', $customer->id), $data)
        ->assertRedirectToRoute('customer.index');

    $customer->refresh();

    expect($customer->profile)->not()->toBeNull();

    Storage::disk('public')->assertExists(config('paths.customer_profile').'/'.$file->hashName());
});

test('show customer detail', function () {
    $customer = Customer::factory()->create();

    getJson(route('customer.show', $customer->id))
        ->assertOk()
        ->assertInertia(
            fn (AssertableInertia $page) => $page->component('Customer/CustomerShow')
                ->where('customer.id', $customer->id)
                ->where('customer.phone_number', $customer->phone_number)
        );
});

test('delete customer', function () {
    $customer = Customer::factory()->create();

    deleteJson(route('customer.destroy'), [
        'ids' => [$customer->id],
    ])->assertRedirectToRoute('customer.index')
        ->assertSessionHas('success', __('lang.deleted_success', ['attribute' => __('lang.customer')]));

    assertSoftDeleted($customer);
});
