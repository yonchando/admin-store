<?php

namespace App\Models\Concerns\User;

use Illuminate\Database\Eloquent\Casts\Attribute;

trait HasAttributes
{
    public function statusText(): Attribute
    {
        return Attribute::make(
            get: function () {
                $status = $this->status;

                return __("lang.$status->value");
            }
        );
    }
}
