<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;

abstract class FilterBuilder
{
    public function __construct(
        protected readonly Builder $builder,
        protected readonly array $filters = [],
    ) {}

    public function apply(): Builder
    {
        foreach ($this->filters as $name => $filter) {
            if ($filter) {
                if (method_exists($this, $name)) {
                    call_user_func([$this, $name], $filter);
                }
            }
        }

        return $this->builder;
    }

    public function includes($withs): void
    {
        $this->builder->with($withs);
    }

    public function sortBy($values): void
    {
        $field = ___($values, 'field');
        $direction = ___($values, 'direction');

        if ($direction !== '-1') {
            $this->builder->orderBy($field, $direction);
        }
    }

    public function gender($value): void
    {
        $this->builder->where('gender', $value);
    }

    public function status($value): void
    {
        $this->builder->where('status', $value);
    }
}
