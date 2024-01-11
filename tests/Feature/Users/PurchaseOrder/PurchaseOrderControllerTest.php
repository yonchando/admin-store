<?php


use Inertia\Testing\AssertableInertia;

test('list orders in index methods', function () {

    $this->get(route('purchase.order.index'))
        ->assertOk()
        ->assertInertia(
            fn(AssertableInertia $page) => $page->component('PurchaseOrder/Index')
                ->has('purchaseOrders.data')
        );

});
