<?php


use App\Models\Card;
use Inertia\Testing\AssertableInertia;
use function Pest\Laravel\get;

test('listing page is response ok', function () {

    Card::factory(3)->create();

    get(route('card.index'))
        ->assertOk()
        ->assertInertia(
            fn(AssertableInertia $page) => $page->component('Card/Index')
                ->has('cards', 3)
        );
});
