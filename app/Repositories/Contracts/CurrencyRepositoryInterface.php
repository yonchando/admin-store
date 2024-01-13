<?php

namespace App\Repositories\Contracts;

use App\Models\Currency;
use Illuminate\Database\Eloquent\Collection;

interface CurrencyRepositoryInterface
{
    /**
     * @return Collection<Currency>
     */
    public function get(): Collection;

    /**
     * @param  int  $id
     * @return Currency
     */
    public function find(int $id): Currency;
}