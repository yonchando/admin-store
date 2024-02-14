<?php

namespace Database\Seeders;

use App\Models\Currency;
use Illuminate\Database\Seeder;

class CurrencySeeder extends Seeder
{
    public function run(): void
    {
        $currencies = [
            ['code' => 'USD', 'name' => 'United States Dollar', 'symbol' => '$', 'exchange_rate' => 1.00],
            ['code' => 'EUR', 'name' => 'Euro', 'symbol' => '€', 'exchange_rate' => 0.85],
            ['code' => 'GBP', 'name' => 'British Pound Sterling', 'symbol' => '£', 'exchange_rate' => 0.73],
            ['code' => 'JPY', 'name' => 'Japanese Yen', 'symbol' => '¥', 'exchange_rate' => 109.27],
            ['code' => 'CHF', 'name' => 'Swiss Franc', 'symbol' => 'Fr', 'exchange_rate' => 0.92],
            ['code' => 'CNY', 'name' => 'Chinese Yuan', 'symbol' => '¥', 'exchange_rate' => 6.47],
            ['code' => 'INR', 'name' => 'Indian Rupee', 'symbol' => '₹', 'exchange_rate' => 74.62],
            ['code' => 'KHR', 'name' => 'Khmer Riel', 'symbol' => '៛', 'exchange_rate' => 4000],
        ];

        foreach ($currencies as $currency) {
            Currency::create($currency);
        }
    }
}
