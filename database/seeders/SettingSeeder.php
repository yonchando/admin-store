<?php

namespace Database\Seeders;

use App\Enums\Setting\SettingKeyEnum;
use App\Models\Currency;
use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        $code = Currency::where('code', 'USD')->first();

        Setting::create([
            'key' => SettingKeyEnum::CURRENCY->value,
            'value' => $code->id,
        ]);

        Setting::create([
            'key' => SettingKeyEnum::SITE_TITLE->value,
            'value' => 'YON Chando',
        ]);
    }
}
