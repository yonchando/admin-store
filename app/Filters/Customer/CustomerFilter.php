<?php

namespace App\Filters\Customer;

use App\Filters\FilterBuilder;
use App\Models\Customer;
use Illuminate\Database\Eloquent\Builder;

/**
 * @property Customer $builder
 */
class CustomerFilter extends FilterBuilder
{
    public function search($value): void
    {
        $this->builder->where(function (Builder $query) use ($value) {
            $query->whereRaw('lower(name) like lower(?)', ["%{$value}%"])
                ->orWhereRaw('lower(email) like lower(?)', ["%{$value}%"])
                ->orWhereRaw('lower(phone_number) like lower(?)', ["%{$value}%"]);
        });
    }
}
