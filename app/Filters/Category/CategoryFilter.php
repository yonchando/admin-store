<?php

namespace App\Filters\Category;

use App\Filters\BuilderFilter;

class CategoryFilter extends BuilderFilter
{
    public function search($search): void
    {
        $this->builder->whereRaw('lower(category_name) like lower(?)', ["%{$search}%"]);
    }

    public function sortBy($filters): void
    {
        $field = ___($filters, 'field');
        $direction = ___($filters, 'direction');

        if ($direction) {
            $this->builder->orderBy($field, $direction);
        }
    }
}
