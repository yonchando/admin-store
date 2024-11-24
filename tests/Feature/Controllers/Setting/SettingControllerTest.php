<?php

use App\Enums\Setting\SettingKeyEnum;
use App\Models\Currency;
use App\Models\Setting;
use Inertia\Testing\AssertableInertia;

use function Pest\Laravel\getJson;
use function Pest\Laravel\putJson;
use function PHPUnit\Framework\assertEquals;

beforeEach(function () {
    asAdmin();
});

test('create setting if not exists', function () {
    $currencies = Currency::factory(3)->create();

    getJson(route('setting.show'))
        ->assertOk()
        ->assertInertia(
            fn (AssertableInertia $page) => $page->component('Setting/SettingShow')
                ->has('currencies', $currencies->count())
                ->has('setting')
        );

});

test('user can update currency', function () {
    $currency = Currency::factory()->create();

    $setting = Setting::factory()->create([
        'key' => SettingKeyEnum::CURRENCY->value,
        'value' => null,
    ]);

    $siteTitle = fake()->name;
    putJson(route('setting.update'), [
        SettingKeyEnum::CURRENCY->value => $currency->id,
        SettingKeyEnum::SITE_TITLE->value => $siteTitle,
    ])->assertRedirect(route('setting.show'));

    $setting->refresh();

    assertEquals($currency->id, $setting->value);
    assertEquals($siteTitle, Setting::firstWhere('key', SettingKeyEnum::SITE_TITLE->value)->value);
});
