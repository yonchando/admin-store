<?php

use App\Casts\ProductObjectCast;
use App\Enums\Product\ProductStatus;
use App\Models\Product;

it('must has attribute image url', function () {
    $product = new Product();

    expect($product->getMutatedAttributes())
        ->toContain('image_url');
});

it('must be has casts json field to product object', function () {
    $product = new Product();

    expect($product->getCasts())->toHaveKey('json', ProductObjectCast::class);
});

it('must be has casts price field to decimal', function () {
    $product = new Product();

    expect($product->getCasts())->toHaveKey('price', 'decimal:2');
});

it('must be has casts status field to enum product status', function () {
    $product = new Product();
    $product->status = ProductStatus::ACTIVE;

    expect($product->getCasts())->toHaveKey('status', ProductStatus::class);
});

it('must be has relationship category', function () {
    $product = new Product();

    expect(method_exists($product, 'category'))->toBeTrue();
});

