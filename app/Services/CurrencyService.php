<?php

namespace App\Services;

use App\Models\Currency;
use Illuminate\Database\Eloquent\Collection;

class CurrencyService
{
    public function get(): Collection
    {
        return Currency::get();
    }

    public function find(int $id): Currency
    {
        return Currency::find($id);
    }
}
