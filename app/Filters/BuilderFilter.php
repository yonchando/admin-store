<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;

abstract class BuilderFilter
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
}
