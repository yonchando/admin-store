<?php

use App\Casts\Setting\SettingPropertyCast;
use App\Enums\GenderEnum;

test('method toArray convert all properties memeber to array', function () {
    $setting = new SettingPropertyCast();
    $setting->currencyId = 1;

    $data = $setting->toArray();

    $this->assertEquals([
        'currency_id' => 1,
    ], $data);
});

test('Enum collection working fine', function () {
    $enum = GenderEnum::toCollection();
    
    expect($enum->pluck('value')->toArray())->toEqual([
        'male',
        'female',
    ]);
});