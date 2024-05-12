<?php

namespace App\Enums;

use App\Traits\HasEnumProperty;

enum GenderEnum: string
{
    use HasEnumProperty;

    case MALE = 'male';
    case FEMALE = 'female';
}
