<?php

namespace App\Services;

use App\Enums\Setting\SettingKeyEnum;
use App\Http\Requests\Setting\SettingRequest;
use App\Models\Setting;

class SettingService
{
    public function save(SettingRequest $request): void
    {
        $keys = SettingKeyEnum::toJson();

        foreach ($keys as $key) {
            $value = ___($request->safe()->except('logo'), $key);
            if ($key === SettingKeyEnum::LOGO->value) {
                $file = $request->file('logo');
                $value = $file->hashName();

                \Storage::putFileAs(config('paths.logo'), $file, $value);
            }

            if (Setting::where('key', $key)->exists()) {
                Setting::where('key', $key)->update(['value' => $value]);
            } else {
                Setting::create([
                    'key' => $key,
                    'value' => $value,
                ]);
            }
        }
    }
}
