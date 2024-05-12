<?php

namespace App\Models\Concerns\Setting;

use Illuminate\Database\Eloquent\Casts\Attribute;

trait HasAttributes
{
    public function currencyId(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->properties->getCurrencyId()
        );
    }
}