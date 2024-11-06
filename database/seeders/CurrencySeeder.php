<?php

namespace Database\Seeders;

use App\Models\Currency;
use Illuminate\Database\Seeder;

class CurrencySeeder extends Seeder
{
    public function run(): void
    {
        $currencies = [
            ['code' => 'USD', 'name' => 'Dollar', 'symbol' => '$'],
            ['code' => 'KHR', 'name' => 'Riel', 'symbol' => '៛'],
        ];

        foreach ($currencies as $currency) {
            Currency::create($currency);
        }
    }
}
