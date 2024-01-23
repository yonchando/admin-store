<?php

namespace App\Models\Concerns\ProductOption;

use App\Facades\Helper;
use Illuminate\Database\Eloquent\Casts\Attribute;

trait HasAttributes
{
    public function priceAdjustmentText(): Attribute
    {
        return Attribute::make(
            get: fn() => ($this->price_adjustment ?? number_format(0, 2))." ".Helper::setting()?->currency->code,
        );
    }
}