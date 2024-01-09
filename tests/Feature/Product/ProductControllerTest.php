<?php

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Inertia\Testing\AssertableInertia;

uses(RefreshDatabase::class);

beforeEach(function () {
    $user = User::factory()->create();
    $this->actingAs($user);
});

test('index methods', function () {
    $products = Product::factory(3)->create();

    $this->get(route('product.index', ['perPage' => 2]))
        ->assertOk()
        ->assertInertia(
            fn(AssertableInertia $page) => $page->component("Product/Index")
                ->has('products.data', 2)
                ->where('products.total', $products->count())
        );
});

test('create methods', function () {
    $categories = Category::factory(3)->create();

    $this->get(route('product.create'))
        ->assertOk()
        ->assertInertia(
            fn(AssertableInertia $page) => $page->component('Product/Form')
                ->has('categories', $categories->count())
        );
});

test('store methods', function () {

    Storage::fake();

    $product = Product::factory()->category()->make([
        'image' => UploadedFile::fake()->image('image.png'),
    ]);

    $this->post(route('product.store'), $product->toArray())
        ->assertRedirect()
        ->assertSessionHas('message', [
            'message' => __('lang.created_success', ['attribute' => __('lang.product')])
        ]);

    $this->assertDatabaseHas($product->getTable(), [
        'product_name' => $product->product_name,
        'description' => $product->description
    ]);

    $product = Product::first();

    expect($product->image)->not()->toBeNull();
    Storage::assertExists(Product::first()->image);

});

test('update methods', function () {
    $product = Product::factory()->create();

    $changed = Product::factory()->make([
        'image' => null,
    ]);

    $this->patch(route('product.update', $product->id), $changed->toArray())
        ->assertRedirect(route('product.index'))
        ->assertSessionHas('message', [
            'message' => __('lang.updated_success', ['attribute' => __('lang.product')])
        ]);

    $this->assertDatabaseMissing($product->getTable(), [
        'product_name' => $product->product_name,
        'description' => $product->description,
    ]);

    $this->assertDatabaseHas($product->getTable(), [
        'product_name' => $changed->product_name,
        'description' => $changed->description,
    ]);

});

it('can update product images', function () {

    Storage::fake();

    $product = Product::factory()->create();

    $changed = Product::factory()->make([
        'image' => UploadedFile::fake()->image('image.png')
    ]);

    $this->patch(route('product.update', $product), $changed->toArray())
        ->assertRedirect(route('product.index'));

    $image = $product->image;

    $product->refresh();

    $this->assertNotEquals($image, $product->image);

    Storage::assertExists($product->image);
});

test('destroy methods', function () {
    $product = Product::factory()->create();

    $this->delete(route('product.destroy', $product))
        ->assertRedirect(route('product.index'));

    $this->assertSoftDeleted($product);
});