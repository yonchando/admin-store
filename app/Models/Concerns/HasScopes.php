<?php

namespace App\Models\Concerns;

use Illuminate\Database\Eloquent\Builder;

trait HasScopes
{
    public function scopeFindByNumber(Builder $query, string $number): Builder
    {
        return $query->where('number', $number);
    }
}
