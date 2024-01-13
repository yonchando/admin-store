<?php

namespace App\Repositories\Contracts;

use App\Http\Requests\SettingRequest;
use App\Models\Setting;

interface SettingRepositoryInterface
{
    public function first(): Setting;

    public function update(SettingRequest $request): Setting;
}