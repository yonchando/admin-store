<?php

namespace App\Models;

use App\Casts\Setting\SettingPropertyCast;
use App\Models\Concerns\Setting\HasAttributes;
use App\Models\Concerns\Setting\HasRelationships;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasAttributes;
    use HasFactory;
    use HasRelationships;

    protected $fillable = [
        'properties',
    ];

    protected $casts = [
        'properties' => SettingPropertyCast::class,
    ];
}
