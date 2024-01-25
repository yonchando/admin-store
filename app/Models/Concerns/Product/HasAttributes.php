<?php

namespace App\Models\Concerns\Product;

use App\Enums\Product\ProductStatus;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Str;

trait HasAttributes
{
    public function imageUrl(): Attribute
    {
        return Attribute::make(
            get: function () {

                if (is_null($this->image)) {
                    return asset('images/placeholders/placeholder.jpg');
                }

                if ((preg_match('/^https?/', $this->image))) {
                    return $this->image;
                }

                return \Storage::url($this->image);
            },
        );
    }

    public function statusText(): Attribute
    {
        return Attribute::make(
            get: fn() => __('lang.'.Str::lower($this->status->name)),
        );
    }

    public function isActive(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->status->name == ProductStatus::ACTIVE->name,
        );
    }
}