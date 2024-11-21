<?php

namespace App\Models\Concerns\Customer;

use App\Filters\Customer\CustomerFilter;
use Illuminate\Database\Eloquent\Builder;

trait HasScopes
{
    public function scopeFilters(Builder $builder, array $filters = []): Builder
    {
        return new CustomerFilter($builder, $filters)->apply();
    }
}
