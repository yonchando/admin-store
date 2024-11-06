<?php

namespace App\Services;

use App\Models\Setting;

class SettingService
{
    public function siteTitle(): Setting
    {
        if (Setting::first() === null) {
            return Setting::with('currency')->create();
        }

        return Setting::with('currency')->first();
    }

    public function save(): Setting
    {
        $setting = new Setting;

        return $setting;
    }
}
