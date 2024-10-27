<?php

namespace App\Filters\Product;

use App\Filters\BuilderFilter;
use App\Models\Category;

class ProductFilter extends BuilderFilter
{
    public function includes($withs): void
    {
        $this->builder->with($withs);
    }

    public function search($value): void
    {
        if ($value) {
            $this->builder->whereRaw('lower(product_name) like lower(?)', ["%$value%"]);
        }
    }

    public function sortBy($sorts): void
    {
        $direction = ___($sorts, 'direction');
        if ($direction) {
            $column = ___($sorts, 'field');
            if ($column == 'category') {
                $this->builder->orderBy(
                    Category::select('category_name')
                        ->whereColumn('id', 'products.category_id')
                        ->orderBy('category_name')
                        ->take(1),
                    $direction);
            } else {
                $this->builder->orderBy($column, $direction);
            }
        }
    }
}
