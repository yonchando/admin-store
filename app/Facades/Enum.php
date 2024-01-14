<?php

namespace App\Facades;

use App\Enums\EnumService;
use Illuminate\Support\Facades\Facade;

class Enum extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return EnumService::class;
    }
}
