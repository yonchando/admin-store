<?php

use App\Enums\Product\ProductStatus;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Testing\Fluent\AssertableJson;
use Inertia\Testing\AssertableInertia;

test('index methods', function () {

    $categories = Category::factory(2)->create();

    $products = Product::factory(3)->create([
        'created_at' => now()->subDay(),
    ]);

    $first = Product::factory()->create([
        'created_at' => now(),
    ]);

    $perPage = 2;

    $this->get(route('product.index', ['perPage' => $perPage]))
        ->assertOk()
        ->assertInertia(
            fn(AssertableInertia $page) => $page->component("Product/Index")
                ->has('products.data', $perPage)
                ->has('categories', $categories->count())
                ->where('statuses', ProductStatus::toArray())
                ->where('products.total', $products->add($first)->count())
                ->where('products.data.0.id', $first->id)
        );
});

test('show methods', function () {
    $product = Product::factory()->create();

    $this->get(route('product.show', $product))
        ->assertOk()
        ->assertInertia(
            fn(AssertableInertia $page) => $page->component("Product/Show")
                ->where('product.id', $product->id)
                ->where('product.product_name', $product->product_name)
        );
});

describe('create product', function () {

    it('can load form create', function () {
        $categories = Category::factory(3)->create();

        $this->get(route('product.create'))
            ->assertOk()
            ->assertInertia(
                fn(AssertableInertia $page) => $page->component('Product/Form')
                    ->has('categories', $categories->count())
            );
    });

    it('can store data to database', function () {

        Storage::fake();

        $product = Product::factory()->category()->make([
            'image' => UploadedFile::fake()->image('image.png'),
        ]);

        $this->post(route('product.store'), $product->toArray())
            ->assertRedirect()
            ->assertSessionHas('message.text', __('lang.created_success', ['attribute' => __('lang.product')]));

        $this->assertDatabaseHas($product->getTable(), [
            'product_name' => $product->product_name,
            'description' => $product->description,
        ]);

        $product = Product::first();

        expect($product->image)->not()->toBeNull();
        Storage::assertExists(Product::first()->image);
    });

});


describe('product edit', function () {

    it("can load form edit", function () {
        $cagtegories = Category::factory(3)->create();
        $product = Product::factory()->create();

        $this->get(route('product.edit', $product))
            ->assertOk()
            ->assertInertia(
                fn(AssertableInertia $page) => $page->component("Product/Form")
                    ->has('categories', $cagtegories->count())
                    ->has('product', fn(AssertableInertia $page) => $page
                        ->where('id', $product->id)
                        ->where('product_name', $product->product_name)->etc()
                    )
            );
    });

    it('update database', function () {
        $product = Product::factory()->create();

        $changed = Product::factory()->make([
            'image' => null,
        ]);

        $this->patch(route('product.update', $product->id), $changed->toArray())
            ->assertRedirect(route('product.index'))
            ->assertSessionHas('message.text', __('lang.updated_success', ['attribute' => __('lang.product')]));

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
            'image' => UploadedFile::fake()->image('image.png'),
        ]);

        $this->patch(route('product.update', $product), $changed->toArray())
            ->assertRedirect(route('product.index'));

        $image = $product->image;

        $product->refresh();

        $this->assertNotEquals($image, $product->image);

        Storage::assertExists($product->image);
    });

    it('can update product status active to inactive and inactive to active', function () {
        $product = Product::factory()->active()->create();

        $this->patchJson(route('product.update.status', $product))
            ->assertOk()
            ->assertJson(
                fn(AssertableJson $json) => $json->where('product.id', $product->id)
                    ->where('product.status', ProductStatus::INACTIVE->name)
                    ->etc()
            );

        $this->patchJson(route('product.update.status', $product))
            ->assertOk()
            ->assertJson(
                fn(AssertableJson $json) => $json->where('product.id', $product->id)
                    ->where('product.status', ProductStatus::ACTIVE->name)
                    ->etc()
            );

    });

});

test('destroy methods', function () {
    $product = Product::factory()->create();

    $this->delete(route('product.destroy', $product))
        ->assertRedirect(route('product.index'));

    $this->assertSoftDeleted($product);
});