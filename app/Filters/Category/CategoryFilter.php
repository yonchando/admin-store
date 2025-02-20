<?php

namespace App\Filters\Category;

use App\Filters\FilterBuilder;

class CategoryFilter extends FilterBuilder
{
    public function search($value): void
    {
        $this->builder->whereRaw('lower(category_name) like lower(?)', ["%{$value}%"]);
    }

    public function parentIdNull($value): void
    {
        if ($value) {
            $this->builder->whereNull('parent_id');
        }
    }

    public function parent($value): void
    {
        $this->builder->where('parent_id', $value);
    }
}
