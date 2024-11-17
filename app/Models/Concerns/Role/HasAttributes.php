<?php

namespace App\Models\Concerns\Role;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Str;

trait HasAttributes
{
    public function code(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value,
            set: fn ($value) => Str::upper(Str::snake(strtolower($value)))
        );
    }

    public function statusText(): Attribute
    {
        return Attribute::get(fn () => __("lang.{$this->status->value}"));
    }
}
