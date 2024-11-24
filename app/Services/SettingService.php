<?php

namespace App\Services;

use App\Enums\Setting\SettingKeyEnum;
use App\Models\Setting;

class SettingService
{
    public function save(array $data): void
    {
        $keys = SettingKeyEnum::toJson();

        foreach ($keys as $key) {
            if (Setting::where('key', $key)->exists()) {
                Setting::where('key', $key)->update(['value' => ___($data, $key)]);
            } else {
                Setting::create([
                    'key' => $key,
                    'value' => ___($data, $key),
                ]);
            }

        }
    }
}
