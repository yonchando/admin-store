<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;

abstract class FilterBuilder
{
    protected $searchable = [];

    public function __construct(
        protected readonly Builder $builder,
        protected readonly array $filters = [],
    ) {}

    public function apply(): Builder
    {
        foreach ($this->filters as $method => $value) {
            if ($value && method_exists($this, $method)) {
                call_user_func([$this, $method], $value);
            }
        }

        return $this->builder;
    }

    protected function search($value): void
    {
        if (! empty($this->searchable) && $value) {
            $this->builder->where(function () use ($value) {
                foreach ($this->searchable as $key => $field) {
                    if ($key === 0) {
                        $this->builder->whereRaw("lower($field) like lower(?)", "%$value%");
                    } else {
                        $this->builder->orWhereRaw("lower($field) like lower(?)", "%$value%");
                    }
                }
            });
        }
    }

    public function includeCount($withCounts): void
    {
        $this->builder->withCount($withCounts);
    }

    public function includes($withs): void
    {
        $this->builder->with($withs);
    }

    public function sortBy($values): void
    {
        $field = ___($values, 'field');
        $direction = ___($values, 'direction', 'desc');

        if ($field !== null && $direction !== '-1') {
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

    public function includeIds($ids): void
    {
        $this->builder->orWhereIn('id', $ids);
    }

    public function excludeIds($ids): void
    {
        $this->builder->whereNotIn('id', $ids);
    }
}
