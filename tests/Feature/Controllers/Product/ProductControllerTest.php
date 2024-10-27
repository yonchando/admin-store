<?php

use App\Enums\Product\ProductStatus;
use App\Facades\Enum;
use App\Models\Category\Category;
use App\Models\Product;
use App\Models\ProductHasOption;
use App\Models\ProductHasOptionGroup;
use App\Models\ProductOption;
use App\Models\ProductOptionGroup;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Testing\Fluent\AssertableJson;
use Inertia\Testing\AssertableInertia;

use function Pest\Laravel\get;

test('index methods', function () {

    $categories = Category::factory(2)->create();

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
            fn (AssertableInertia $page) => $page->component('Product/Index')
                ->has('products.data', $perPage)
                ->has('categories', $categories->count())
                ->where('statuses', Enum::toSelectedForm(ProductStatus::cases()))
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
                fn (AssertableInertia $page) => $page->component('Product/Show')
                    ->where('product.id', $product->id)
                    ->where('product.product_name', $product->product_name)
            );
    });

    it('can load product option and options', function () {
        $group = ProductOptionGroup::factory()->create();

        $options = ProductOption::factory(3)->create();

        $product = Product::factory()->create();

        $hasGroup = ProductHasOptionGroup::factory()
            ->optionGroup($group->id)
            ->product($product->id)->create();

        $hasOptions = ProductHasOption::factory(3)
            ->hasGroupId($hasGroup->id)
            ->option(
                new Sequence(
                    $options->first()->id,
                    $options->get(1)->id,
                    $options->last()->id,
                )
            )
            ->create();

        $this->get(route('product.show', $product))
            ->assertOk()
            ->assertInertia(
                fn (AssertableInertia $page) => $page->component('Product/Show')
                    ->where('product.id', $product->id)
                    ->where('product.product_name', $product->product_name)
                    ->has('product.product_has_option_groups', 1)
                    ->has('product.product_has_option_groups.0.product_has_options', $options->count())
            );

    });
});

describe('create product', function () {

    it('can load form create', function () {
        $categories = Category::factory(3)->create();

        $this->get(route('product.create'))
            ->assertOk()
            ->assertInertia(
                fn (AssertableInertia $page) => $page->component('Product/Form')
                    ->has('categories', $categories->count())
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
            ->assertSessionHas('message.text', __('lang.created_success', ['attribute' => __('lang.product')]));

        $this->assertDatabaseHas($product->getTable(), [
            'product_name' => $product->product_name,
            'description' => $product->description,
        ]);

        $product = Product::first();

        expect($product->json->image)->not()->toBeNull();

        Storage::assertExists($product->json->image->getPath());

        expect($product->json->image->getUrl())->toEqual(Storage::url(config('paths.product_image').'/'.$image->hashName()));
    });
});

describe('product edit', function () {

    it('can load form edit', function () {
        $categories = Category::factory(3)->create();
        $product = Product::factory()->create();

        $this->get(route('product.edit', $product))
            ->assertOk()
            ->assertInertia(
                fn (AssertableInertia $page) => $page->component('Product/Form')
                    ->has('categories', $categories->count())
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

        $this->patch(route('product.update', $product), $changed->toArray())
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

        $file = UploadedFile::fake()->image('image.png');

        $changed = Product::factory()->make([
            'image' => $file,
        ]);

        $this->patch(route('product.update', $product), $changed->toArray())
            ->assertRedirect(route('product.index'));

        $image = $product->json->image->getUrl();

        $product->refresh();

        $this->assertNotEquals($image, $product->json->image->getUrl());

        Storage::assertExists($product->json->image->getPath());

        expect($product->json->image->getUrl())->toEqual(Storage::url(config('paths.product_image').'/'.$file->hashName()));
    });

    it('can update product status active to inactive and inactive to active', function () {
        $product = Product::factory()->active()->create();

        $this->patchJson(route('product.update.status', $product))
            ->assertOk()
            ->assertJson(
                fn (AssertableJson $json) => $json->where('product.id', $product->id)
                    ->where('product.status', ProductStatus::INACTIVE->value)
                    ->etc()
            );

        $this->patchJson(route('product.update.status', $product))
            ->assertOk()
            ->assertJson(
                fn (AssertableJson $json) => $json->where('product.id', $product->id)
                    ->where('product.status', ProductStatus::ACTIVE->value)
                    ->etc()
            );
    });
});

describe('delete function', function () {
    it('can delete product', function () {
        $product = Product::factory()->create();

        $this->delete(route('product.destroy', $product))
            ->assertRedirect(route('product.index'));

        $this->assertSoftDeleted($product);
    });

    it('can delete product option group in product detail', function () {
        $group = ProductOptionGroup::factory()->create();
        $option = ProductOption::factory()->create();

        $product = Product::factory()->create();

        $productHasOptionGroup = ProductHasOptionGroup::create([
            'product_id' => $product->id,
            'product_option_group_id' => $group->id,
        ]);

        $productHasOption = ProductHasOption::create([
            'product_has_option_group_id' => $productHasOptionGroup->id,
            'product_option_id' => $option->id,
        ]);

        $this->from(route('product.show', $product));

        $this->delete(route('product.destroy.product.option.group', $productHasOptionGroup))
            ->assertRedirect(route('product.show', $product))
            ->assertSessionHas(
                'message.text',
                __('lang.deleted_success', ['attribute' => __('lang.product_option_group')])
            );

        $product->refresh();

        $this->assertModelMissing($productHasOptionGroup);
        $this->assertDatabaseEmpty($productHasOption->getTable());
        $this->assertEmpty($product->productOptionGroups);
        $this->assertEmpty($product->productOptions);
    });

    it('can delete option from groups', function () {
        $group = ProductOptionGroup::factory()->create();
        $option = ProductOption::factory()->create();

        $product = Product::factory()->create();

        $productHasOptionGroup = ProductHasOptionGroup::create([
            'product_id' => $product->id,
            'product_option_group_id' => $group->id,
        ]);

        $productHasOption = ProductHasOption::create([
            'product_has_option_group_id' => $productHasOptionGroup->id,
            'product_option_id' => $option->id,
        ]);

        $this->from(route('product.show', $product));

        $this->delete(route('product.destroy.product.option', $productHasOption))
            ->assertRedirectToRoute('product.show', $product)
            ->assertSessionHas('message.text', __('lang.deleted_success', ['attribute' => __('lang.product_option')]));

        $this->assertModelMissing($productHasOption);
        $this->assertEmpty($product->productHasOptions);
    });
});
