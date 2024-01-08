<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Session;

class HelperService
{
    public function message($message, $key = 'message'): void
    {
        Session::flash($key, [
            'message' => $message
        ]);
    }
}