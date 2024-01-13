<?php

namespace App\Repositories;

use App\Http\Requests\SettingRequest;
use App\Models\Setting;
use App\Repositories\Contracts\SettingRepositoryInterface;

class SettingRepository implements SettingRepositoryInterface
{

    public function first(): Setting
    {
        return Setting::with('currency')->firstOrCreate();
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