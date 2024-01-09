<?php

namespace App\Models\Concerns\Product;

use Illuminate\Database\Eloquent\Casts\Attribute;

trait HasAttributes
{
    public function imageUrl(): Attribute
    {
        return Attribute::make(
            get: fn() => (preg_match('/^https?/',$this->image)) ? $this->image : \Storage::url($this->image),
        );
    }
}