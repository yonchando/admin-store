<?php

namespace App\Models;

use App\Enums\Setting\SettingKeyEnum;
use App\Models\Concerns\Setting\HasAttributes;
use App\Models\Concerns\Setting\HasRelationships;
use App\Models\Concerns\Setting\HasScopes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasAttributes;
    use HasFactory;
    use HasRelationships;
    use HasScopes;

    protected $fillable = [
        'key',
        'value',
    ];

    protected $casts = [
        'key' => SettingKeyEnum::class,
        'other' => 'json',
    ];

    public static function findByKey(string|SettingKeyEnum $key): ?Setting
    {
        return Setting::where('key', $key)->first();
    }
}
