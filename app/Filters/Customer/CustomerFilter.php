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
            $query->whereRaw('lower(nickname) like ?', ["%{$value}%"])
                ->orWhereRaw('lower(email) like ?', ["%{$value}%"])
                ->orWhereRaw('lower(phone) like ?', ["%{$value}%"]);
        });
    }
}
