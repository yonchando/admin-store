<?php

namespace Database\Seeders;

use App\Casts\Setting\SettingProperty;
use App\Models\Currency;
use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        $property = new SettingProperty;
        $property->currency = Currency::where('code', 'USD')->first()->code;

        Setting::create([
            'properties' => $property,
        ]);
    }
}
