<?php

namespace App\Filters\Purchase;

use App\Filters\FilterBuilder;
use App\Models\Purchase;

/**
 * @property Purchase $builder
 */
class PurchaseFilter extends FilterBuilder
{
    public function search($value): void
    {
        $this->builder->where('ref_no', $value);
    }
}
