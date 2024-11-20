<?php

namespace App\Models\Concerns\Customer;

use Illuminate\Database\Eloquent\Casts\Attribute;

trait HasAttributes
{
    public function genderText(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->gender ? __("lang.{$this->gender->value}") : null,
        );
    }
}
