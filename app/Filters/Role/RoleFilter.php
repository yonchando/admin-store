<?php

namespace App\Filters\Role;

use App\Filters\FilterBuilder;
use App\Models\Role;

/**
 * @property Role $builder
 */
class RoleFilter extends FilterBuilder
{
    public function search($value): void
    {
        $this->builder->whereRaw('lower(name) like lower(?)', ["%{$value}%"]);
    }
}
