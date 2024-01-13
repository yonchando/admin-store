<?php

namespace App\Models\Concerns\Setting;

use App\Models\Currency;

trait HasRelationships
{
    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }
}