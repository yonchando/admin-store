<?php

namespace App\Models\Concerns\Customer;

use Illuminate\Database\Eloquent\Casts\Attribute;

trait HasAttributes
{
    public function name(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->first_name." ".$this->last_name
        );
    }

    public function genderText(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->gender ? __("lang.$this->gender") : null,
        );
    }
}