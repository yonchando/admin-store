<?php

namespace App\ValueObjects\Setting;

use App\ValueObjects\ValueObject;
use Illuminate\Contracts\Support\Arrayable;

class SettingObject extends ValueObject implements Arrayable
{
    public ?int $currency_id = null;
}