<?php

use App\Enums\Order\PurchaseStatusEnum;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\PurchaseDetail;
use Inertia\Testing\AssertableInertia;

use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\from;
use function Pest\Laravel\getJson;
use function Pest\Laravel\patchJson;
use function Pest\Laravel\postJson;
use function Pest\Laravel\putJson;

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

test('update purchase status', function () {
    $purchase = Purchase::factory()->create([
        'status' => PurchaseStatusEnum::PENDING,
    ]);

    $data = [
        'status' => PurchaseStatusEnum::ACCEPTED->value,
    ];

    from(route('purchase.show', $purchase->id), []);

    $res = patchJson(route('purchase.update.status', $purchase->id), $data);

    $res->assertRedirectToRoute('purchase.show', $purchase->id)
        ->assertSessionHas('success', "Purchase {$data['status']} successfully!.");

    $purchase->refresh();

    expect($purchase->status)->toBe(PurchaseStatusEnum::ACCEPTED);
});

test('update status validation', function () {
    $purchase = Purchase::factory()->create([
        'status' => PurchaseStatusEnum::PENDING,
    ]);

    $data = [
        'status' => PurchaseStatusEnum::COMPLETED->value,
    ];

    from(route('purchase.show', $purchase->id), [])
        ->patchJson(route('purchase.update.status', $purchase->id), $data)
        ->assertJsonValidationErrors([
            'status' => 'Invalid status',
        ]);

    $purchase->refresh();

    expect($purchase->status)->toBe(PurchaseStatusEnum::PENDING);
});

test('update status reject or cancel transaction need reason', function () {
    $purchase = Purchase::factory()->create([
        'status' => PurchaseStatusEnum::PENDING,
    ]);

    $data = [
        'status' => PurchaseStatusEnum::REJECTED->value,
        'reason' => 'out of stock',
    ];

    from(route('purchase.show', $purchase->id), [])
        ->patchJson(route('purchase.update.status', $purchase->id), $data)
        ->assertRedirectToRoute('purchase.show', $purchase->id)
        ->assertSessionHas('success', "Purchase {$data['status']} successfully!.");

    $purchase->refresh();

    expect($purchase->status)->toBe(PurchaseStatusEnum::REJECTED)
        ->and($purchase->json->reason)->toEqual('out of stock');
});

test('update purchase', function () {
    $details = PurchaseDetail::factory(2);

    $purchase = Purchase::factory()->has($details)->create();

    $product = Product::factory()->create([
        'price' => 10,
    ]);
    $detail = PurchaseDetail::factory()->create([
        'purchase_id' => $purchase->id,
        'qty' => 2,
        'price' => $product->price,
        'product_id' => $product->id,
        'sub_total' => 10,
    ]);

    $product = Product::factory()->create();
    $qty = fake()->numberBetween(1, 10);
    $item = [
        ...$purchase->purchaseDetails->take(2)->map(function ($purchaseDetail) {
            return [
                'id' => $purchaseDetail->id,
                'qty' => $purchaseDetail->qty,
                'product_id' => $purchaseDetail->product_id,
            ];
        }),
        [
            'id' => $detail->id,
            'qty' => 5,
            'product_id' => $detail->product_id,
        ],
        [
            'id' => null,
            'qty' => $qty,
            'product_id' => $product->id,
        ],
    ];
    $data = [
        'customer_id' => $purchase->customer_id,
        'purchase_date' => $purchase->purchased_at,
        'status' => PurchaseStatusEnum::PENDING->value,
        'products' => [
            ...$item,
        ],
    ];

    putJson(route('purchase.update', $purchase->id), $data)
        ->assertRedirectToRoute('purchase.index')
        ->assertSessionHas('success', __('lang.updated_success', ['attribute' => __('lang.purchase')]));

    $purchase->refresh();

    expect($purchase->purchaseDetails->firstWhere('id', $detail->id)->qty)->toEqual(5);
});
