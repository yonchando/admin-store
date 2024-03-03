<?php

namespace App\Models\Concerns\Product;

use App\Enums\Product\ProductStatus;
use App\Facades\Helper;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Str;

trait HasAttributes
{
    public function imageUrl(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->json->image->url,
        );
    }

    public function statusText(): Attribute
    {
        return Attribute::make(
            get: fn() => __('lang.'.Str::lower($this->status->name)),
        );
    }

    public function priceText(): Attribute
    {
        $code = data_get(Helper::setting(), 'currency.code', 'USD');
        return Attribute::make(
            get: fn() => $this->price ? $this->price." $code" : null,
        );
    }

    public function isActive(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->status->name == ProductStatus::ACTIVE->name,
        );
    }
}
