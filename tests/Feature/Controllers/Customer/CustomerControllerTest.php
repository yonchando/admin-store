<?php


use App\Enums\GenderEnum;
use App\Models\Customer;
use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderDetail;
use Inertia\Testing\AssertableInertia;

test('customer listing', function () {
    $first = Customer::factory()->has(PurchaseOrder::factory(3))->create([
        'first_name' => 'Customer',
        'last_name' => 'Test',
        'phone' => '+85512312312',
        'gender' => GenderEnum::MALE->value,
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
                    ->where('gender_text', __('lang.'.GenderEnum::MALE->value))
                    ->etc()
                )
        );
});

test('show customer detail', function () {
    $customer = Customer::factory()->has(PurchaseOrder::factory(2)->has(PurchaseOrderDetail::factory(3),'purchaseDetails'))->create();

    $this->get(route('customer.show', $customer))
        ->assertOk()
        ->assertInertia(
            fn(AssertableInertia $page) => $page->component('Customer/Show')
                ->where('customer.purchase_orders_count', 2)
                ->where('customer.purchase_orders.0.purchase_details_count', 3)
        );
});
