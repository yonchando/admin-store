<?php

namespace App\Services;

use App\Http\Requests\Setting\SettingRequest;
use App\Models\Setting;
use App\Services\Contracts\SettingRepositoryInterface;

class SettingRepository implements SettingRepositoryInterface
{
    public function first(): Setting
    {
        if (Setting::first() === null) {
            return Setting::with('currency')->create();
        }

        return Setting::with('currency')->first();
    }

    public function update(SettingRequest $request): Setting
    {
        $setting = $this->first();
        $setting->properties->currency_id = $request->get('currency_id');
        $setting->save();
        $setting->refresh();

        return $setting;
    }
}
