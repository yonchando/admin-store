<?php

namespace App\ValueObjects\Setting;

use App\ValueObjects\ValueObject;
use Illuminate\Contracts\Support\Arrayable;

class CurrencyObject extends ValueObject implements Arrayable
{
    public int $currencyId;
}