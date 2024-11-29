<?php

namespace App\Models\Concerns\Category;

use Illuminate\Database\Eloquent\Builder;

trait HasScopes
{
    public function scopeSlug(Builder $query, ?string $slug = null): Builder
    {
        return $query->where('slug', $slug);
    }
}
