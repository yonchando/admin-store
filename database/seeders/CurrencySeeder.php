<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CurrencySeeder extends Seeder
{
    public function run(): void
    {
        \DB::raw("
            INSERT INTO currencies (code, name, symbol, exchange_rate) VALUES ('USD', 'United States Dollar', '$', 1.00);
            INSERT INTO currencies (code, name, symbol, exchange_rate) VALUES ('EUR', 'Euro', '€', 0.85);
            INSERT INTO currencies (code, name, symbol, exchange_rate) VALUES ('GBP', 'British Pound Sterling', '£', 0.73);
            INSERT INTO currencies (code, name, symbol, exchange_rate) VALUES ('JPY', 'Japanese Yen', '¥', 109.27);
            INSERT INTO currencies (code, name, symbol, exchange_rate) VALUES ('CHF', 'Swiss Franc', 'Fr', 0.92);
            INSERT INTO currencies (code, name, symbol, exchange_rate) VALUES ('CNY', 'Chinese Yuan', '¥', 6.47);
            INSERT INTO currencies (code, name, symbol, exchange_rate) VALUES ('INR', 'Indian Rupee', '₹', 74.62);
            INSERT INTO currencies (code, name, symbol, exchange_rate) VALUES ('KHR', 'Khmer Riel', '៛', 1.40);
        ");
    }
}
