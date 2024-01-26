<?php

use App\Enums\Product\ProductStatus;
use App\Facades\Enum;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductHasOption;
use App\Models\ProductOption;
use App\Models\ProductOptionGroup;
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
                ->where('statuses', Enum::toSelectedForm(ProductStatus::cases()))
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

        $data = $product->toArray();

        $data['product_options'][] = [
            'product_option_group_id' => null,
            'options' => [
                [
                    'product_option_id' => null,
                ],
            ],
        ];
        $data['product_options'][] = [
            'product_option_group_id' => null,
            'options' => [
                [
                    'product_option_id' => null,
                ],
            ],
        ];

        $this->post(route('product.store'), $data)
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

    it('can store product with product option', function () {
        $group = ProductOptionGroup::factory()->create();
        $options = ProductOption::factory(3)->create();

        $data = Product::factory()->category()->make()->toArray();

        $data['product_options'][] = [
            'product_option_group_id' => $group->id,
            'options' => $options->map(
                fn($value) => [
                    'product_option_id' => $value->id,
                    'price_adjustment' => fake()->randomFloat(2, 0, 1),
                ]
            )->toArray(),
        ];

        $this->post(route('product.store'), $data)
            ->assertRedirect()
            ->assertSessionHas('message.text', __('lang.created_success', ['attribute' => __('lang.product')]));

        $product = Product::with(['productOptionGroups', 'productOptions'])->first();

        $this->assertDatabaseHas($product->getTable(), [
            'product_name' => $product->product_name,
            'description' => $product->description,
        ]);

        $this->assertNotEmpty($product->productOptionGroups);

        $this->assertNotEmpty(
            $product->productOptions->whereIn(
                'product_has_option_group_id',
                $product->productOptionGroups->pluck('pivot.product_option_group_id')
            )
        );

        $this->assertEquals($options->count(), $product->productOptions->count());

        $this->assertDatabaseHas('product_has_option_groups', [
            'product_option_group_id' => $group->id,
            'product_id' => $product->id,
        ]);
    });

    it('can add more product option from product detail', function () {
        $product = Product::factory()->create();

        $group = ProductOptionGroup::factory()->create();
        $options = ProductOption::factory(3)->create();

        $data = [
            'product_options' => [
                [
                    'product_option_group_id' => $group->id,
                    'options' => $options->map(
                        fn($value) => [
                            'product_option_id' => $value->id,
                            'price_adjustment' => fake()->randomFloat(2, 0, 5),
                        ]
                    )->toArray(),
                ],
            ],
        ];

        $this->post(route('product.store.product.option', $product), $data)
            ->assertRedirectToRoute('product.show', $product)
            ->assertSessionHas('message.text', __('lang.add_success', ['attribute' => __('lang.product_option')]));

        $this->assertNotEmpty($product->productOptionGroups);

        $this->assertNotEmpty(
            $product->productOptions->whereIn(
                'product_has_option_group_id',
                $product->productOptionGroups->pluck('pivot.product_option_group_id')
            )
        );

        $this->assertEquals($options->count(), $product->productOptions->count());
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
                    ->has(
                        'product',
                        fn(AssertableInertia $page) => $page
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

        $productHasOptionGroup = \App\Models\ProductHasOptionGroup::create([
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
});
