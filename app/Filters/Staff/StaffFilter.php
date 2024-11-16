<?php

namespace App\Filters\Staff;

use App\Filters\FilterBuilder;
use App\Models\Staff;
use Illuminate\Database\Eloquent\Builder;

/**
 * @property Staff $builder
 */
class StaffFilter extends FilterBuilder
{
    public function search($search): void
    {
        $this->builder->where(
            fn (Builder $query) => $query->whereRaw(
                'lower(name) like lower(?) or lower(username) like lower(?)',
                ["%$search%", "%$search%"]
            )
        );
    }

    public function gender($value): void
    {
        $this->builder->where('gender', $value);
    }
}
