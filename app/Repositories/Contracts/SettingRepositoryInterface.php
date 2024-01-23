<?php

namespace App\Repositories\Contracts;

use App\Http\Requests\Setting\SettingRequest;
use App\Models\Setting;

interface SettingRepositoryInterface
{
    public function first(): Setting;

    public function update(SettingRequest $request): Setting;
}