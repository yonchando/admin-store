<?php

namespace App\Filters\Staff;

use App\Filters\FilterBuilder;
use App\Models\Staff;

/**
 * @property Staff $builder
 */
class StaffFilter extends FilterBuilder
{
    protected $searchable = ['name', 'username'];

    public function gender($value): void
    {
        $this->builder->where('gender', $value);
    }

    public function status($value): void
    {
        $this->builder->where('status', $value);
    }
}
