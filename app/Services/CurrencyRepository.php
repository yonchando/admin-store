<?php

namespace App\Services;

use App\Models\Currency;
use App\Services\Contracts\CurrencyRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class CurrencyRepository implements CurrencyRepositoryInterface
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
