<?php

namespace App\Facades;

use App\Helpers\HelperService;
use Illuminate\Support\Facades\Facade;

class Helper extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return HelperService::class;
    }
}
