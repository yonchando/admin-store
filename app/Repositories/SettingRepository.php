<?php

namespace App\Repositories;

use App\Http\Requests\Setting\SettingRequest;
use App\Models\Setting;
use App\Repositories\Contracts\SettingRepositoryInterface;
use Illuminate\Support\Facades\Route;

class SettingRepository implements SettingRepositoryInterface
{

    public function first(): Setting
    {
        if (Setting::first() === null) {
            return Setting::create();
        }
        return Setting::first();
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