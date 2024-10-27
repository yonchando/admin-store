<?php

namespace App\Casts\Setting;

use Yonchando\CastAttributes\CastAttributes;

class SettingProperty extends CastAttributes
{
    public ?string $currency = null;
}
