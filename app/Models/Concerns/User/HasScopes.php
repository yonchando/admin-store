<?php

namespace App\Models\Concerns\User;

use App\Filters\Staff\StaffFilter;
use Illuminate\Database\Eloquent\Builder;

trait HasScopes
{
    public function scopeIsNotAdmin(Builder $query): Builder
    {
        return $query->where('is_admin', false);
    }

    public function scopeFilters(Builder $query, ?array $filters = []): Builder
    {
        return (new StaffFilter($query, $filters))->apply();
    }
}
