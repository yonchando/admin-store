<?php


use App\Enums\Gender;
use App\Models\Customer;
use App\Models\PurchaseOrder;
use Inertia\Testing\AssertableInertia;

test('customer listing', function () {
    $first = Customer::factory()->hasPurchaseOrders(3)->create([
        'first_name' => 'Customer',
        'last_name' => 'Test',
        'phone' => '+85512312312',
        'gender' => Gender::MALE->value,
    ]);

    $customers = Customer::factory(3)->create();

    $this->get(route('customer.index'))
        ->assertOk()
        ->assertInertia(
            fn(AssertableInertia $page) => $page->component('Customer/Index')
                ->has('customers.data', $customers->add($first)->count())
                ->has(
                    'customers.data.0', fn(AssertableInertia $page) => $page->where('purchase_orders_count', 3)
                    ->where('name', 'Customer Test')
                    ->where('phone', '+85512312312')
                    ->where('gender_text', __('lang.'.Gender::MALE->value))
                    ->etc()
                )
        );
});

test('show custoemr detail', function () {
    $customer = Customer::factory()->has(PurchaseOrder::factory(2)->hasOrderItems(3))->create();

    $this->get(route('customer.show', $customer))
        ->assertOk()
        ->assertInertia(
            fn(AssertableInertia $page) => $page->component('Customer/Show')
                ->where('customer.purchase_orders_count', 2)
                ->where('customer.purchase_orders.0.order_items_count', 3)
        );
});
