<?php

namespace App\Helpers;

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
}