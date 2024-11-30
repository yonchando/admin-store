<?php

namespace App\Models\Concerns\Product;

use App\Enums\Product\ProductStatusEnum;
use App\Filters\Product\ProductFilter;
use Illuminate\Database\Eloquent\Builder;

trait HasScopes
{
    public function scopeFilters(Builder $query, array $filters): Builder
    {
        return new ProductFilter($query, $filters)->apply();
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('status', ProductStatusEnum::ACTIVE->name);
    }

    public function scopeInactive(Builder $query): Builder
    {
        return $query->where('status', ProductStatusEnum::INACTIVE);
    }

    public function scopeByCategoryId(Builder $query, int $id): Builder
    {
        return $query->where('category_id', $id);
    }

    public function scopeSlug(Builder $query, string $slug): Builder
    {
        return $query->where('slug', $slug);
    }
}
