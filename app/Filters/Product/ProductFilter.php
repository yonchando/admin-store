<?php

namespace App\Filters\Product;

use App\Filters\FilterBuilder;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Validation\ValidationException;

/**
 * @property Product $builder
 */
class ProductFilter extends FilterBuilder
{
    public function search($value): void
    {
        if ($value) {
            $this->builder->whereRaw('lower(product_name) like lower(?)', ["%$value%"]);
        }
    }

    public function sortBy($values): void
    {
        $direction = ___($values, 'direction');
        $column = ___($values, 'field');

        if ($direction !== '-1') {
            if ($column == 'category') {
                $query = Category::select('category_name')
                    ->whereColumn('id', 'products.category_id')
                    ->orderBy('category_name')
                    ->take(1);
                $this->builder->orderBy(
                    $query,
                    $direction);
            } else {
                $this->builder->orderBy($column, $direction);
            }
        }
    }

    public function price(array $price = []): void
    {
        $prices = ___($price, 'value');
        if (count($prices) !== 2) {
            throw ValidationException::withMessages([
                'price' => 'Price range must be only has 2 values',
            ]);
        }

        if ($prices[0] == null) {
            $this->builder->where('price', '<=', $prices[1]);
        } elseif ($prices[1] == null) {
            $this->builder->where('price', '>=', $prices[0]);
        } else {
            $this->builder->whereBetween('price', $prices);
        }
    }

    public function category($categoryId): void
    {
        $this->builder->where('category_id', $categoryId);
    }
}
