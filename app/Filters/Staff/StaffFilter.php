<?php

namespace App\Filters\Staff;

use App\Filters\FilterBuilder;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;

/**
 * @property User $builder
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
