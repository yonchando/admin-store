<?php


use App\Models\ProductOption;
use Inertia\Testing\AssertableInertia;

test('list product option response ok', function () {
    ProductOption::factory(3)->create();
    $this->get(route('product.option.index'))
        ->assertOk()
        ->assertInertia(
            fn(AssertableInertia $page) => $page->component('ProductOption/Index')
                ->has('productOptions', 3)
        );
});

describe('store product', function () {

    it('can not store product option with out field name', function () {
        $this->from(route('product.option.index'));

        $this->post(route('product.option.store'))
            ->assertRedirectToRoute('product.option.index')
            ->assertSessionHasErrors('name', __('validation.required', ['attribute' => 'name']));
    });

    it('can store product option with valid data and response success', function () {
        $option = ProductOption::factory()->make();

        $this->from(route('product.option.index'));

        $this->post(route('product.option.store'), $option->toArray())
            ->assertRedirectToRoute('product.option.index')
            ->assertSessionHas('message.text', __('lang.created_success', ['attribute' => __('lang.product_option')]));

        $this->assertDatabaseHas($option->getTable(), [
            'name' => $option->name,
            'price_adjustment' => $option->price_adjustment,
        ]);
    });
});

describe('update product option', function () {

    it('can update product option', function () {
        $option = ProductOption::factory()->create();

        $changed = ProductOption::factory()->make();

        $this->patch(route('product.option.update', $option), $changed->toArray())
            ->assertRedirectToRoute('product.option.index')
            ->assertSessionHas('message.text', __('lang.updated_success', ['attribute' => __('lang.product_option')]));

        $updated = $option->fresh();

        $this->assertEquals($changed->name, $updated->name);
        $this->assertEquals($changed->price_adjustment, $updated->price_adjustment);

        $this->assertNotEquals($option->name, $updated->name);
        $this->assertNotEquals($option->price_adjustment, $updated->price_adjustment);
    });
});

test('destroy product option success', function () {
    $option = ProductOption::factory()->create();
});