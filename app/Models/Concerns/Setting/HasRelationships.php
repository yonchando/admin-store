<?php

namespace App\Models\Concerns\Setting;

use App\Models\Currency;

trait HasRelationships
{
    public function currency(): Currency
    {
        return Currency::where('code', $this->value)->first();
    }
}
