<?php

namespace App\Models\Concerns\Product;

use App\Enums\Product\ProductStatus;
use Illuminate\Database\Eloquent\Builder;

trait HasScopes
{
    /**
     * @param  array{
     *     category_id: int,
     *     search: string,
     *     min_price: double,
     *     max_price: double,
     *     status: string,
     *     order_by: string,
     *     order_direction: string,
     * }  $filters
     */
    public function scopeFilters(Builder $query, array $filters): Builder
    {
        if (isset($filters['category_id'])) {
            $query->where('category_id', $filters['category_id']);
        }

        if (isset($filters['search'])) {
            $search = $filters['search'];
            $query->whereRaw('lower(products.product_name) like lower(?)', "%$search%");
        }

        if (isset($filters['min_price']) && isset($filters['max_price'])) {
            $query->whereBetween('price', [$filters['min_price'], $filters['max_price']]);
        } else {
            if (isset($filters['min_price'])) {
                $query->where('price', '>=', $filters['min_price']);
            }

            if (isset($filters['max_price'])) {
                $query->where('price', '<=', $filters['max_price']);
            }
        }

        if (isset($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (isset($filters['order_by']) && isset($filters['order_direction'])) {
            $query->where($filters['order_by'], $filters['order_direction']);
        } else {
            $query->latest()->latest('created_at');
        }

        return $query;
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('status', ProductStatus::ACTIVE->name);
    }

    public function scopeInactive(Builder $query): Builder
    {
        return $query->where('status', ProductStatus::INACTIVE);
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
