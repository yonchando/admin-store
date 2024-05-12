<?php

namespace App\ValueObjects\Setting;

use App\ValueObjects\JsonProperty;

class SettingObject extends JsonProperty
{
    public ?int $currency_id = null;
}
