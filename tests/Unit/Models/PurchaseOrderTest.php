<?php

use App\Models\Purchase;

test('purchase order must has relation ship with order item model', function () {
    $purchase = new Purchase;

    $this->assertTrue(method_exists($purchase, 'purchaseDetails'));
});

test('purchase order must have purchased_date property', function () {
    $purchase = new Purchase;

    $this->assertTrue(method_exists($purchase, 'purchasedDate'));
});
