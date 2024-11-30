<?php

namespace App\Filters\Purchase;

use App\Filters\FilterBuilder;
use App\Models\Customer;
use App\Models\Purchase;

/**
 * @property Purchase $builder
 */
class PurchaseFilter extends FilterBuilder
{
    public function search($value): void
    {
        $this->builder->where(function ($query) use ($value) {
            $query->where('ref_no', $value);
            $query->orWhereHas('customer', function ($query) use ($value) {
                $query->whereRaw('lower(name) like lower(?) or lower(phone_number) like lower(?)', ["%{$value}%", "%{$value}%"]);
            });
        });
    }

    public function sortBy($values): void
    {
        $field = ___($values, 'field');
        $direction = ___($values, 'direction');

        if ($direction !== '-1') {

            if ($field === 'customer') {
                $customer = Customer::select(['name'])
                    ->whereColumn('id', '=', 'purchases.customer_id')
                    ->orderBy('name')
                    ->take(1);
                $this->builder->orderBy($customer, $direction);
            } else {
                $this->builder->orderBy($field, $direction);
            }

        } else {
            $this->builder->orderBy('purchased_at', 'desc');
        }
    }
}
