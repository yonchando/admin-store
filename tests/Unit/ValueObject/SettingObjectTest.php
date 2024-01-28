<?php

use App\ValueObjects\Setting\SettingObject;

test('method toArray convert all properties memeber to array', function () {
    $setting = new SettingObject();
    $setting->currency_id = 1;

    $data = $setting->toArray();

    $this->assertEquals([
        'currency_id' => 1,
    ], $data);
});
