<?php

use App\Enums\Order\PurchaseStatusEnum;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\PurchaseDetail;
use Inertia\Testing\AssertableInertia;

use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\getJson;
use function Pest\Laravel\postJson;

beforeEach(function () {
    asAdmin();
});

test('listing purchase', function () {
    $purchase = Purchase::factory(40)->create();

    getJson(route('purchase.index'))
        ->assertOk()
        ->assertInertia(
            fn (AssertableInertia $page) => $page->component('Purchase/PurchaseIndex')
                ->has('purchases.data', $purchase->take(20)->count())
                ->where('purchases.total', $purchase->count())
        );
});

test('create purchase', function () {
    getJson(route('purchase.create'))
        ->assertOk()
        ->assertInertia(
            fn (AssertableInertia $page) => $page->component('Purchase/PurchaseForm')
                ->where('statuses', PurchaseStatusEnum::toArray())
        );
});

test('store purchase', function () {
    $customer = Customer::factory()->create();

    $product1 = Product::factory()->create();
    $product2 = Product::factory()->create();
    $product3 = Product::factory()->create();

    $data = [
        'customer_id' => $customer->id,
        'products' => [
            [
                'qty' => 2,
                'product_id' => $product1->id,
            ],
            [
                'qty' => 5,
                'product_id' => $product2->id,
            ],
            [
                'qty' => 3,
                'product_id' => $product3->id,
            ],
        ],
        'purchase_date' => now()->toDateTimeString(),
        'status' => PurchaseStatusEnum::PENDING,
    ];

    postJson(route('purchase.store'), $data)
        ->assertRedirectToRoute('purchase.index')
        ->assertSessionHas('success', __('lang.created_success', ['attribute' => __('lang.purchase')]));

    assertDatabaseHas(Purchase::class, [
        'customer_id' => $customer->id,
    ]);

    assertDatabaseHas(PurchaseDetail::class, [
        'product_id' => $product1->id,
        'qty' => $data['products'][0]['qty'],
        'price' => $product1->price,
        'sub_total' => $product1->price * $data['products'][0]['qty'],
    ]);
});
