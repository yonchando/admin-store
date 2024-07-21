<?php

namespace App\Casts\Setting;

use Yonchando\CastAttributes\CastAttributes;

class SettingPropertyCast extends CastAttributes
{
    public ?int $currencyId = null;

    public function get($model, string $key, $value, array $attributes): ?SettingPropertyCast
    {
        if (is_null($value)) {
            return null;
        }

        return self::create(json_decode($value));
    }

}
