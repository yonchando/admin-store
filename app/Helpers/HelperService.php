<?php

namespace App\Helpers;

use App\Models\Setting;
use Illuminate\Support\Facades\Session;

class HelperService
{
    public function message($message, $type = 'success', $key = 'message'): void
    {
        Session::flash($key, [
            'text' => $message,
            'type' => $type,
        ]);
    }

    public function setting(): Setting
    {
        return session('setting');
    }
}