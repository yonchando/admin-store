<?php

namespace App\Enums\Setting;

use App\Traits\HasEnumProperty;

enum SettingKeyEnum: string
{
    use HasEnumProperty;

    case SITE_TITLE = 'site_title';
    case LOGO = 'logo';
    case CURRENCY = 'currency';
}
