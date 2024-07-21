<?php

use App\Models\ProductOption;
use Inertia\Testing\AssertableInertia;
use function Pest\Laravel\putJson;

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

    it('can store multiple product option in one request', function () {
        $options = ProductOption::factory(3)->make();

        $this->from(route('product.option.index'));

        $res = $this->post(route('product.option.store.many'), [
            'options' => $options->toArray(),
        ]);

        $res->assertRedirectToRoute('product.option.index')
            ->assertSessionHas('message.text', __('lang.created_success', ['attribute' => __('lang.product_option')]));

        $this->assertDatabaseCount(ProductOption::newModelInstance()->getTable(), $options->count());
    });
});

describe('update product option', function () {

    it('can update product option', function () {
        $option = ProductOption::factory()->create();

        $changed = ProductOption::factory()->make();

        putJson(route('product.option.update', $option), $changed->toArray())
            ->assertRedirectToRoute('product.option.index')
            ->assertSessionHas('message.text', __('lang.updated_success', ['attribute' => __('lang.product_option')]));

        $updated = $option->fresh();

        $this->assertEquals($changed->name, $updated->name);
        $this->assertEquals($changed->price_adjustment, $updated->price_adjustment);

        $this->assertNotEquals($option->name, $updated->name);
        $this->assertNotEquals($option->price_adjustment, $updated->price_adjustment);
    });
});

describe('delete product option', function () {
    it('can delete product option', function () {
        $option = ProductOption::factory()->create();

        $this->delete(route('product.option.destroy', $option))
            ->assertRedirectToRoute('product.option.index')
            ->assertSessionHas('message.text', __('lang.deleted_success', ['attribute' => __('lang.product_option')]));

        $this->assertModelMissing($option);
    });

    it('can delete product option multiple ids', function () {

        $options = ProductOption::factory(3)->create();

        $this->delete(route('product.option.destroy.many'), [
            'ids' => $options->pluck('id')->toArray(),
        ])
            ->assertRedirectToRoute('product.option.index')
            ->assertSessionHas('message.text', __('lang.deleted_success', ['attribute' => __('lang.product_option')]));

        $this->assertDatabaseEmpty($options->first()->getTable());
    });

    it('can not delete multiple product option with ids is not array', function () {

        $this->from(route('product.option.index'));

        $this->delete(route('product.option.destroy.many'), [
            'ids' => collect(),
        ])
            ->assertRedirectToRoute('product.option.index')
            ->assertSessionHasErrors('ids', __("validation.array", ["attribute" => __('ids')]));

    });
});
