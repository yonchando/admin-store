<?php

namespace App\Models\Concerns\ProductOption;

use App\Facades\Helper;
use Illuminate\Database\Eloquent\Casts\Attribute;

trait HasAttributes
{
    public function priceAdjustmentText(): Attribute
    {
        return Attribute::make(
            get: fn() => data_get($this,'price_adjustment'),
        );
    }
}