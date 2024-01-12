<?php


use App\Enums\PurchaseOrder\PurchaseOrderStatus;
use App\Models\Customer;
use App\Models\PurchaseOrder;
use Inertia\Testing\AssertableInertia;

test('list orders in index methods', function () {

    $purchases = PurchaseOrder::factory(3)->hasOrderItems(3)
        ->purchasedAt(now()->subDay()->toDateTimeString())->create();

    $first = PurchaseOrder::factory()->hasOrderItems(2)
        ->purchasedAt()->create();

    $this->get(route('purchase.order.index', ['perPage' => 2]))
        ->assertOk()
        ->assertInertia(
            fn(AssertableInertia $page) => $page->component('PurchaseOrder/Index')
                ->has('purchaseOrders.data', 2)
                ->has(
                    'purchaseOrders.data.0',
                    fn(AssertableInertia $page) => $page->where('id', $first->id)
                        ->where('customer.name', $first->customer->name)
                        ->where('order_items_count', 2)
                        ->where('purchased_date', $first->purchased_date)
                        ->where('status_text', $first->status_text)
                        ->etc()
                )
                ->where('status', PurchaseOrderStatus::toJson())
                ->where('purchaseOrders.total', $purchases->add($first)->count())
        );
});

test('show detail purchase', function () {

    $customer = Customer::factory()->create();
    $purchase = PurchaseOrder::factory()->hasOrderItems(3)->customer($customer->id)->create();

    $this->get(route('purchase.order.show', $purchase))
        ->assertOk()
        ->assertInertia(
            fn(AssertableInertia $page) => $page->component('PurchaseOrder/Show')
                ->has(
                    'purchase',
                    fn(AssertableInertia $page) => $page->where('id', $purchase->id)
                        ->where('customer.name', $customer->name)
                        ->has('order_items', 3)
                        ->etc()
                )
        );
});

describe('update purchase status', function () {

    it('can not updated with invalid status', function () {
        $purchase = PurchaseOrder::factory()->create();

        $res = $this->from(route('purchase.order.index'))
            ->patch(route('purchase.order.update.status', $purchase), [
                'status' => 'invalid-status',
            ]);

        $res->assertSessionHasErrors();
        $res->assertRedirect(route('purchase.order.index'));
    });

    it('can purchase order status', function ($status) {

        $purchase = PurchaseOrder::factory()->create();

        $this->patchJson(route('purchase.order.update.status', $purchase), [
            'status' => $status,
        ])->assertRedirect(route('purchase.order.index'));

        $purchase->refresh();

        $this->assertEquals($status, $purchase->status->name);

    })->with([
        'approved' => [PurchaseOrderStatus::ACCEPTED->name],
        'shipped' => [PurchaseOrderStatus::SHIPPED->name],
        'cancel' => [PurchaseOrderStatus::CANCELED->name],
    ]);
});