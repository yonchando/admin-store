<?php

namespace App\ValueObjects\Setting;

use App\ValueObjects\JsonProperty;
use Illuminate\Contracts\Support\Arrayable;

class CurrencyObject extends JsonProperty implements Arrayable
{
    public int $currencyId;
}
