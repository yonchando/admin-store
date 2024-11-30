<?php

namespace App\Filters\Category;

use App\Filters\FilterBuilder;

class CategoryFilter extends FilterBuilder
{
    public function search($search): void
    {
        $this->builder->whereRaw('lower(category_name) like lower(?)', ["%{$search}%"]);
    }

    public function sortBy($filters): void
    {
        $field = ___($filters, 'field');
        $direction = ___($filters, 'direction');

        if ($direction != '-1') {
            $this->builder->orderBy($field, $direction);
        }
    }
}
