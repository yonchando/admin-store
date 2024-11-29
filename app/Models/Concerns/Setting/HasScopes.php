<?php

namespace App\Models\Concerns\Setting;

use Illuminate\Database\Eloquent\Builder;

trait HasScopes
{
    public function scopeKeyBy(Builder $builder, string $key): Builder
    {
        return $builder->where('key', $key);
    }
}
