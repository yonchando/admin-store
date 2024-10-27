<?php

namespace App\Models\Category;

use Illuminate\Database\Eloquent\Builder;

class CategoryFilter
{
    private $sortable = ['category_name', 'created_at'];

    public function __construct(
        private readonly Builder $builder,
        private readonly array $filters = [],
    ) {}

    public function apply(): Builder
    {
        foreach ($this->filters as $name => $filter) {
            if (method_exists($this, $name)) {
                call_user_func([$this, $name], $filter);
            }
        }

        return $this->builder;
    }

    private function search($search): void
    {
        $this->builder->whereRaw('lower(category_name) like lower(?)', ["%{$search}%"]);
    }

    private function sortable($filters): void
    {
        $field = ___($filters, 'field');
        $direction = ___($filters, 'direction');
        if (in_array($field, $this->sortable) && in_array($direction, ['asc', 'desc'])) {
            $this->builder->orderBy($field, $direction);
        }
    }
}
