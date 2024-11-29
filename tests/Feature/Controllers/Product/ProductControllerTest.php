<?php

use App\Enums\Product\ProductStatusEnum;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Inertia\Testing\AssertableInertia;

use function Pest\Laravel\delete;
use function Pest\Laravel\get;
use function Pest\Laravel\putJson;

beforeEach(function () {
    asAdmin();
});

test('index methods', function () {

    $products = Product::factory(3)->create([
        'created_at' => now()->subDay(),
    ]);

    $first = Product::factory()->create([
        'created_at' => now(),
    ]);

    $perPage = 2;

    get(route('product.index', ['perPage' => $perPage]))
        ->assertOk()
        ->assertInertia(
            fn (AssertableInertia $page) => $page->component('Product/ProductIndex')
                ->has('products.data', $perPage)
                ->where('statuses', ProductStatusEnum::toArray())
                ->where('products.total', $products->add($first)->count())
                ->where('products.data.0.id', $first->id)
        );
});

describe('show product detail', function () {
    it('show product detail', function () {
        $product = Product::factory()->create();

        $this->get(route('product.show', $product))
            ->assertOk()
            ->assertInertia(
                fn (AssertableInertia $page) => $page->component('Product/ProductShow')
                    ->where('product.id', $product->id)
                    ->where('product.product_name', $product->product_name)
            );
    });
});

describe('create product', function () {

    it('can load form create', function () {
        $categories = Category::factory(3)->create();

        $this->get(route('product.create'))
            ->assertOk()
            ->assertInertia(
                fn (AssertableInertia $page) => $page->component('Product/ProductForm')
                    ->where('statuses', ProductStatusEnum::toArray())
                    ->etc()
            );
    });

    it('can store data to database', function () {

        Storage::fake();

        $image = UploadedFile::fake()->image('image.png');

        $product = Product::factory()->category()->make([
            'image' => $image,
        ]);

        $data = $product->toArray();

        $this->post(route('product.store'), $data)
            ->assertRedirect()
            ->assertSessionHas('success', __('lang.created_success', ['attribute' => __('lang.product')]));

        $this->assertDatabaseHas($product->getTable(), [
            'product_name' => $product->product_name,
            'description' => $product->description,
        ]);

        $product = Product::first();

        expect($product->json->image)->not()->toBeNull();

        Storage::assertExists($product->json->image->path);

        expect($product->json->image->url)->toEqual(Storage::url(config('paths.product_image').'/'.$image->hashName()));
    });
});

describe('product edit', function () {

    it('can load form edit', function () {
        $product = Product::factory()->create();

        get(route('product.edit', $product))
            ->assertOk()
            ->assertInertia(
                fn (AssertableInertia $page) => $page->component('Product/ProductForm')
                    ->has(
                        'product',
                        fn (AssertableInertia $page) => $page
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

        putJson(route('product.update', $product), $changed->toArray())
            ->assertRedirect(route('product.index'))
            ->assertSessionHas('success', __('lang.updated_success', ['attribute' => __('lang.product')]));

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

        $file = UploadedFile::fake()->image('image.png');

        $changed = Product::factory()->make([
            'image' => $file,
        ]);

        putJson(route('product.update', $product), $changed->toArray())
            ->assertRedirect(route('product.index'));

        $image = $product->json->image->url;

        $product->refresh();

        $this->assertNotEquals($image, $product->json->image->url);

        Storage::assertExists($product->json->image->path);

        expect($product->json->image->url)->toEqual(Storage::url(config('paths.product_image').'/'.$file->hashName()));
    });

    it('can update product status active to inactive and inactive to active', function () {
        $product = Product::factory()->active()->create();

        putJson(route('product.update.status', $product))
            ->assertRedirectToRoute('product.index');

        $product->refresh();

        expect($product->status)->toBe(ProductStatusEnum::INACTIVE);

        putJson(route('product.update.status', $product))
            ->assertRedirectToRoute('product.index');

        $product->refresh();

        expect($product->status)->toBe(ProductStatusEnum::ACTIVE);
    });
});

describe('delete function', function () {
    it('can delete product', function () {
        $product = Product::factory()->create();

        delete(route('product.destroy'), [
            'ids' => [$product->id],
        ])->assertRedirect(route('product.index'));

        $this->assertSoftDeleted($product);
    });
});
