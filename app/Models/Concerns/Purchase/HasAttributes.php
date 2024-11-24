<?php

namespace App\Models\Concerns\Purchase;

use Illuminate\Database\Eloquent\Casts\Attribute;

trait HasAttributes
{
    public function total(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => '$'.number_format($value, 2),
            set: fn ($value) => $value,
        );
    }
}
