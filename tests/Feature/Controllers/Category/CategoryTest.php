<?php

use App\Models\Category;
use Inertia\Testing\AssertableInertia;

use function Pest\Laravel\from;
use function Pest\Laravel\putJson;

beforeEach(function () {
    asUser();
});

test('index method', function () {

    $category = Category::factory(3)->create();

    $perPage = 1;

    $res = $this->get(route('category.index', ['perPage' => $perPage]));

    $res->assertOk();
    $res->assertInertia(
        fn (AssertableInertia $page) => $page->component('Category/CategoryIndex')
            ->has('categories.data', $perPage)
            ->where('categories.total', $category->count())
    );
});

it('order category by latest', function () {
    $first = Category::factory()->create([
        'created_at' => now()->subMinutes(3),
    ]);
    $second = Category::factory()->create([
        'created_at' => now(),
    ]);

    $this->get(route('category.index'))
        ->assertOk()
        ->assertInertia(
            fn (AssertableInertia $page) => $page->component('Category/CategoryIndex')
                ->where('categories.data.0.id', $second->id)
                ->where('categories.data.1.id', $first->id)
        );
});

it('validate data before store', function () {
    $this->from(route('category.index'))
        ->post(route('category.store'), [])
        ->assertInvalid([
            'category_name' => __('validation.required', ['attribute' => 'category name']),
        ])->assertRedirect(route('category.index'));

    $category = Category::factory()->create();
    $this->from(route('category.index'))
        ->post(route('category.store'), $category->toArray())
        ->assertInvalid([
            'category_name' => __('validation.unique', ['attribute' => 'category name']),
        ])->assertRedirect(route('category.index'));

});

test('store method', function () {
    $category = Category::factory()->make();

    $this->post(route('category.store'), $category->toArray())
        ->assertRedirect(route('category.index'))
        ->assertSessionHas('success', __('lang.created_success', ['attribute' => __('lang.category')]));

    $this->assertDatabaseHas($category->getTable(), [
        'category_name' => $category->category_name,
        'slug' => Str::slug($category->category_name),
    ]);
});

test('update method', function () {
    $category = Category::factory()->create();

    $name = 'changed name';

    putJson(route('category.update', $category), [
        'category_name' => $name,
    ])->assertRedirect(route('category.index'))
        ->assertSessionHas('success', __('lang.updated_success', ['attribute' => __('lang.category')]));

    $changed = $category->fresh();

    expect($changed->category_name)->toBe($name)
        ->and($changed->slug)->toBe(Str::slug($name));
});

test('destroy methods', function () {
    $category = Category::factory()->create();

    from(route('category.index'))
        ->delete(route('category.destroy'), ['ids' => [$category->id]])
        ->assertRedirect(route('category.index'))
        ->assertSessionHas('success', __('lang.deleted_success', ['attribute' => __('lang.category')]));

    $this->assertDatabaseMissing($category->getTable(), [
        'category_name' => $category->category_name,
    ]);
});
