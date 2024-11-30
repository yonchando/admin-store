<?php

namespace App\Models\Concerns\Role;

use App\Enums\Role\RoleStatusEnum;
use App\Filters\Role\RoleFilter;
use Illuminate\Database\Eloquent\Builder;

trait HasScopes
{
    public function scopeDefault(Builder $builder): Builder
    {
        return $builder->where('status', RoleStatusEnum::ACTIVE->value);
    }

    public function scopeFilters(Builder $builder, array $filters = []): Builder
    {
        return new RoleFilter($builder, $filters)->apply();
    }
}
