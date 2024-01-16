<?php


use App\Models\ProductOptionGroup;
use Inertia\Testing\AssertableInertia;

test('listing product option', function () {

    $groups = ProductOptionGroup::factory()->create();

    $this->get(route('product.option.group.index'))
        ->assertOk()
        ->assertInertia(
            fn(AssertableInertia $page) => $page->component('ProductOption/Index')
                ->has('groups', $groups->count())
        );
});

test('store product option group', function () {

    $group = ProductOptionGroup::factory()->make();

    $this->from(route('product.option.group.index'));

    $this->post(route('product.option.group.store'), [
        ...$group->only('name'),
    ])
        ->assertRedirectToRoute('product.option.group.index')
        ->assertSessionHas('message.text',
            __('lang.created_success', ['attribute' => __('lang.product_option_group')]));

    $this->assertDatabaseHas($group->getTable(), [
        'name' => $group->name,
    ]);

});

test('update product option group', function () {

    $group = ProductOptionGroup::factory()->create();

    $change = ProductOptionGroup::factory()->make();

    $this->from(route('product.option.group.index'));

    $this->patch(route('product.option.group.update', $group), [
        ...$change->only('name'),
    ])
        ->assertRedirectToRoute('product.option.group.index')
        ->assertSessionHas('message.text',
            __('lang.updated_success', ['attribute' => __('lang.product_option_group')]));

    $updated = $group->fresh();

    $this->assertEquals($change->name, $updated->name);

    $this->assertDatabaseHas($group->getTable(), [
        'name' => $change->name,
    ]);

    $this->assertDatabaseMissing($group->getTable(), [
        'name' => $group->name,
    ]);

});

test('delete product option group', function () {

    $group = ProductOptionGroup::factory()->create();

    $this->from(route('product.option.group.index'));

    $this->delete(route('product.option.group.destroy', $group))
        ->assertRedirectToRoute('product.option.group.index')
        ->assertSessionHas('message.text',
            __('lang.deleted_success', ['attribute' => __('lang.product_option_group')]));

    $this->assertModelMissing($group);
});