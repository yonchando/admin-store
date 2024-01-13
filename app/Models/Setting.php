<?php

namespace App\Models;

use App\Models\Casts\SettingObjectCast;
use App\Models\Concerns\Setting\HasAttributes;
use App\Models\Concerns\Setting\HasRelationships;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;
    use HasRelationships;
    use HasAttributes;

    protected $fillable = [
        'properties',
    ];

    protected $casts = [
        'properties' => SettingObjectCast::class,
    ];
}