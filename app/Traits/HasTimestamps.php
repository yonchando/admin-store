<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Casts\Attribute;

trait HasTimestamps
{
    public function createdAt(): Attribute
    {
        return Attribute::make(
            get: function () {
                return _date(___($this->attributes, 'created_at'));
            },
            set: fn ($value) => $value,
        );
    }

    public function updatedAt(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => _date(___($this->attributes, 'updated_at')),
            set: fn ($value) => $value,
        );
    }

    public function deletedAt(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => _date(___($this->attributes, 'deleted_at')),
            set: fn ($value) => $value,
        );
    }
}
