<?php

use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia;

uses(RefreshDatabase::class);

beforeEach(function () {
    $user = User::factory()->create();
    $this->actingAs($user);
});

test('index method', function () {

    $category = Category::factory(3)->create();

    $perPage = 1;

    $res = $this->get(route('category.index', ['perPage' => $perPage]));

    $res->assertOk();
    $res->assertInertia(fn(AssertableInertia $page) => $page->component('Category/Index')
        ->has('categories.data', $perPage)
        ->where('categories.total', $category->count())
    );
});

it('order cateogry by latest', function () {
    $first = Category::factory()->create([
        'created_at' => now()->subMinutes(3),
    ]);
    $second = Category::factory()->create([
        'created_at' => now(),
    ]);

    $this->get(route('category.index'))
        ->assertOk()
        ->assertInertia(fn(AssertableInertia $page) => $page->component('Category/Index')
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

test('store mehtod', function () {
    $cateogry = Category::factory()->make();

    $this->post(route('category.store'), $cateogry->toArray())
        ->assertRedirect(route('category.index'))
        ->assertSessionHas('message', __('lang.success'));

    $this->assertDatabaseHas($cateogry->getTable(), [
        'category_name' => $cateogry->category_name,
        'slug' => Str::slug($cateogry->category_name),
    ]);
});

test("update method", function () {
    $cateogry = Category::factory()->create();

    $name = 'changed name';

    $this->patch(route('category.update', $cateogry), [
        'category_name' => $name,
    ])->assertRedirect(route('category.index'))
        ->assertSessionHas('message', __('lang.success'));

    $changed = $cateogry->fresh();

    expect($changed->category_name)->toBe($name);
    expect($changed->slug)->toBe(Str::slug($name));
});

test('destroy methods', function () {
    $category = Category::factory()->create();

    $this->from(route('category.index'))
        ->delete(route('category.destroy', $category))
        ->assertRedirect(route('category.index'));

    $this->assertDatabaseMissing($category->getTable(), [
        'category_name' => $category->category_name,
    ]);
});
