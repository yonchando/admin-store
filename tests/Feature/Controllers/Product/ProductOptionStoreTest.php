<?php


use App\Models\Product;
use App\Models\ProductHasOptionGroup;
use App\Models\ProductOption;
use App\Models\ProductOptionGroup;

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

    $product = Product::with(['productOptionGroups', 'productHasOptions'])->first();

    $this->assertDatabaseHas($product->getTable(), [
        'product_name' => $product->product_name,
        'description' => $product->description,
    ]);

    $this->assertNotEmpty($product->productOptionGroups);

    $this->assertNotEmpty(
        $product->productHasOptions->whereIn(
            'product_has_option_group_id',
            $product->productOptionGroups->pluck('pivot.product_option_group_id')
        )
    );

    $this->assertEquals($options->count(), $product->productHasOptions->count());

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
        $product->productHasOptions->whereIn(
            'product_has_option_group_id',
            $product->productOptionGroups->pluck('pivot.product_option_group_id')
        )
    );

    $this->assertEquals($options->count(), $product->productHasOptions->count());
});

describe('store option to product option group', function () {

    it('can not store data with invalid data', function () {
        $product = Product::factory()->create();

        $request = [
            'options' => [
                [
                    'product_has_option_group_id' => 1, // not exists id
                    'product_option_id' => 1, // not exists id
                    'price_adjustment' => fake()->randomFloat(2, 0, 1),
                ],
            ],
        ];

        $this->from(route('product.show', $product));

        $this->post(route('product.add.option', $product), $request)
            ->assertRedirectToRoute('product.show', $product)
            ->assertSessionHasErrors([
                'options.*.product_option_id',
                'options.*.product_has_option_group_id',
            ]);
    });

    it('can add option to exists product option group', function () {
        $group = ProductOptionGroup::factory()->create();
        $options = ProductOption::factory(3)->create();

        $product = Product::factory()->create();

        $productHasOptionGroup = ProductHasOptionGroup::create([
            'product_id' => $product->id,
            'product_option_group_id' => $group->id,
        ]);

        $request = [
            'options' => $options->map(fn($value) => [
                'product_has_option_group_id' => $productHasOptionGroup->id,
                'product_option_id' => $value->id,
                'price_adjustment' => fake()->randomFloat(2, 0, 1),
            ])->toArray(),
        ];

        $this->from(route('product.show', $product));

        $this->post(route('product.add.option', $product), $request)
            ->assertRedirectToRoute('product.show', $product)
            ->assertSessionHas('message.text', __('lang.add_success', ['attribute' => __('lang.product_option')]));

        $product->refresh();

        $getOptions = $product->productHasOptions->whereIn('product_has_option_group_id', $productHasOptionGroup->id);

        $this->assertEquals($options->count(), $getOptions->count());
    });

});
