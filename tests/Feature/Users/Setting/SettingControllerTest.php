<?php

use App\Models\Currency;
use App\Models\Setting;
use Inertia\Testing\AssertableInertia;

test('create setting if not exists', function () {

    $currencies = Currency::factory(3)->create();

    $this->get(route('setting.show'))
        ->assertOk()
        ->assertInertia(
            fn(AssertableInertia $page) => $page->component('Setting/Show')
                ->has('currencies', $currencies->count())
                ->where('setting.id', 1)
        );

    $this->assertDatabaseCount('settings', 1);
});

test('user can update currency', function () {

    $currency = Currency::factory()->create();

    $res = $this->put(route('setting.update'), [
        'currency_id' => $currency->id,
    ]);

    $res->assertRedirect(route('setting.show'));

    $setting = Setting::first();

    $this->assertEquals($currency->id, $setting->properties->currency_id);
});