<?php

namespace App\Models\Concerns\Product;

use App\Enums\Product\ProductStatusEnum;
use Illuminate\Database\Eloquent\Casts\Attribute;

trait HasAttributes
{
    public function imageUrl(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->json?->image->url,
        );
    }

    public function isActive(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->status->name == ProductStatusEnum::ACTIVE->name,
        );
    }
}
