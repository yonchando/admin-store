<?php

namespace App\Helpers;

use App\Models\Setting;
use App\Repositories\Contracts\SettingRepositoryInterface;
use Illuminate\Support\Facades\Session;

class HelperService
{

    public function __construct(
        private readonly SettingRepositoryInterface $settingRepository,
    ) {
    }

    public function message($message, $type = 'success', $key = 'message'): void
    {
        Session::flash($key, [
            'text' => $message,
            'type' => $type,
        ]);
    }

    public function setting(): Setting|null
    {
        return $this->settingRepository->first();
    }
}