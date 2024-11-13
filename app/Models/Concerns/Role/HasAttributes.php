<?php

namespace App\Models\Concerns\Role;

use Illuminate\Database\Eloquent\Casts\Attribute;

trait HasAttributes
{
    public function statusText(): Attribute
    {
        return Attribute::get(fn ($item) => __("lang.{$this->status->value}"));
    }
}
