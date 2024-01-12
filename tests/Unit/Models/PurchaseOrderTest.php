<?php

use App\Models\PurchaseOrder;

test('purchase order must has relation ship with order item model', function () {
    $purchase = new PurchaseOrder();

    $this->assertTrue(method_exists($purchase, 'orderItems'));
});

test('purchase order must have purchased_date property', function () {
    $purchase = new PurchaseOrder();

    $this->assertTrue(method_exists($purchase, 'purchasedDate'));
});

