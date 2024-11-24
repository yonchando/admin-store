<?php

namespace App\Models\Concerns\Purchase;

use App\Filters\Purchase\PurchaseFilter;
use Illuminate\Database\Eloquent\Builder;

trait HasScopes
{
    public function scopeFilters(Builder $builder, array $filters = []): Builder
    {
        return new PurchaseFilter($builder, $filters)->apply();
    }
}
