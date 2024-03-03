<?php


use App\Models\Card;
use App\Models\Customer;
use Inertia\Testing\AssertableInertia;
use function Pest\Laravel\assertModelMissing;
use function Pest\Laravel\delete;
use function Pest\Laravel\from;
use function Pest\Laravel\get;
use function Pest\Laravel\post;
use function Pest\Laravel\put;

test('listing carding', function () {
    $card = Card::factory(3)->create();

    get(route('card.index'))
        ->assertOk()
        ->assertInertia(
            fn(AssertableInertia $page) => $page->component('Card/Index')
                ->has('cards', $card->count())
        );
});

test('create form card loading ok', function () {

    get(route('card.create'))
        ->assertOk()
        ->assertInertia(
            fn(AssertableInertia $page) => $page->component('Card/Form')
        );
});

test('store card', function () {
    $data = [
        'name' => fake()->name,
    ];

    post(route('card.store'), $data)
        ->assertRedirect()
        ->assertSessionHas('message.text', __('lang.created_success', ['attribute' => __('lang.card')]));

    $card = Card::first();

    expect($card)->not()->toBeNull()
        ->and($card->name)->toEqual($data['name']);

});

test('show card detail', function () {
    $card = Card::factory()->create();

    get(route('card.show', $card))
        ->assertOk()
        ->assertInertia(
            fn(AssertableInertia $page) => $page->component('Card/Show')
                ->has('card')
                ->where('card.id', $card->id)
                ->where('card.name', $card->name),
        );
});

test('edit card', function () {
    $card = Card::factory()->create();

    get(route('card.edit', $card))
        ->assertOk()
        ->assertInertia(
            fn(AssertableInertia $page) => $page->component('Card/Form')
                ->where('card.id', $card->id)
                ->where('card.name', $card->name)
        );
});

test('update card', function () {

    $card = Card::factory()->create();

    $data = [
        'name' => fake()->name,
    ];

    from(route('card.show', $card));

    put(route('card.update', $card), $data)
        ->assertRedirectToRoute('card.show', $card)
        ->assertSessionHas('message.text', __('lang.updated_success', ['attribute' => __('lang.card')]));

    $updated = $card->fresh();

    expect($updated->name)->toEqual($data['name']);
});

test('destroy card', function () {
    $card = Card::factory()->create();

    delete(route('card.destroy', $card))
        ->assertRedirectToRoute('card.index')
        ->assertSessionHas('message.text', __('lang.deleted_success', ['attribute' => __('lang.card')]));

    assertModelMissing($card);
});
