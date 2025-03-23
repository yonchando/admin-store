<?php

test('method toArray convert all properties memeber to array', function () {
    $setting = new Setting;
    $setting->currency_id = 1;

    $data = $setting->toArray();

    $this->assertEquals([
        'currency_id' => 1,
    ], $data);
});
