<?php

namespace App\Models\Concerns\ProductOption;

use Illuminate\Database\Eloquent\Builder;

trait HasScopes
{
    public function scopeFindByGroupId(Builder $query, int $id): Builder
    {
        return $query->where('group_id', $id);
    }
}