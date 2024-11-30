<?php

namespace App\Filters\Module;

use App\Filters\FilterBuilder;
use App\Models\Module;

/**
 * @property Module $builder;
 */
class ModuleFilter extends FilterBuilder
{
    public function search($value): void
    {
        $this->builder->whereRaw('lower(name) like lower(?)', "%$value%");
    }

    public function sortBy($values): void
    {
        $field = ___($values, 'field');
        $direction = ___($values, 'direction');

        if ($direction !== '-1') {
            $this->builder->orderBy($field, $direction);
        }
    }
}
