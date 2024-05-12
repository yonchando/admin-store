<?php

use App\Enums\Product\ProductStatus;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia;

describe('product filters', function () {

    it('filter all', function () {
        $category = Category::factory()->create()->refresh();
        $product = Product::factory()->category($category->id)
            ->active()
            ->create([
                'product_name' => 'Product Name',
                'price' => 100,
            ])->refresh();

        $res = $this->get(route('product.index', [
            'search' => 'product',
            'category_id' => $category->id,
            'min_price' => 50,
            'max_price' => 200,
        ]));

        $res->assertOk()
            ->assertInertia(
                fn(AssertableInertia $page) => $page->component('Product/Index')
                    ->has('products.data', 1)
                    ->has(
                        'products.data.0',
                        fn(AssertableInertia $page) => $page->where('id', $product->id)
                            ->where('product_name', $product->product_name)
                            ->etc()
                    )
                    ->where('categories.0', $category)
                    ->has(
                        'filters',
                        fn(AssertableInertia $page) => $page->where('search', 'product')
                            ->where('category_id', "$category->id")
                            ->where('min_price', '50')
                            ->where('max_price', '200')
                            ->etc()
                    )
            );
    });

    it('filter by product name', function () {
        Product::factory()->create(['product_name' => "Other Name"],);
        $products = Product::factory(2)->create(
            new Sequence(
                ['product_name' => "Search Name"],
                ['product_name' => "Search Other"],
            ));

        $res = $this->get(route('product.index', [
            'search' => 'search',
        ]));

        $res->assertOk()
            ->assertInertia(
                fn(AssertableInertia $page) => $page->component('Product/Index')
                    ->has('products.data', $products->count())
                    ->where('products.data.0.product_name', 'Search Name')
                    ->where('products.data.1.product_name', 'Search Other')
            );
    });

    it('filter by category', function () {
        Product::factory(2)->category()->create();

        $category = Category::factory()->create();
        $products = Product::factory(2)->category($category->id)->create();

        $res = $this->get(route('product.index', [
            'category_id' => $category->id,
        ]));

        $res->assertOk()
            ->assertInertia(
                fn(AssertableInertia $page) => $page->component("Product/Index")
                    ->has('products.data', $products->count())
            );
    });

    it('filter by price range', function ($min_price, $max_price, $expectation) {
        Product::factory(4)->create(
            new Sequence(
                ['price' => 10],
                ['price' => 20],
                ['price' => 30],
                ['price' => 40],
            )
        );

        $res = $this->get(route('product.index', [
            'min_price' => $min_price,
            'max_price' => $max_price,
        ]));

        $res->assertOk()
            ->assertInertia(
                fn(AssertableInertia $page) => $page->component('Product/Index')
                    ->has('products.data', $expectation)
            );
    })->with([
        'fiter between' => [19, 40, 3],
        'filter min price to highter price' => [19, null, 3],
        'filter max price to lower price' => [null, 39, 3],
    ]);

    it('filter by status', function () {
        $actives = Product::factory(3)->active()->create();
        $inactives = Product::factory(2)->inactive()->create();

        $this->get(route('product.index', [
            'status' => ProductStatus::ACTIVE->value,
        ]))->assertOk()->assertInertia(
            fn(AssertableInertia $page) => $page->component('Product/Index')
                ->has('products.data', $actives->count())
        );

        $this->get(route('product.index', [
            'status' => ProductStatus::INACTIVE->value,
        ]))->assertOk()->assertInertia(
            fn(AssertableInertia $page) => $page->component('Product/Index')
                ->has('products.data', $inactives->count())
        );
    });

});
