<?php

namespace App\Models\Concerns\Customer;

use Illuminate\Database\Eloquent\Casts\Attribute;

trait HasAttributes
{
    public function phone(): Attribute
    {
        return Attribute::get(fn () => "($this->country_code) $this->phone_number");
    }
}
