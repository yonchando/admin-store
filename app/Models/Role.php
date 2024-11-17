<?php

namespace App\Models;

use App\Enums\Role\RoleStatusEnum;
use App\Models\Concerns\Role\HasAttributes;
use App\Models\Concerns\Role\HasRelationships;
use App\Models\Concerns\Role\HasScopes;
use App\Traits\HasPermission;
use App\Traits\HasTimestamps;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasAttributes;
    use HasFactory;
    use HasPermission;
    use HasRelationships;
    use HasScopes;
    use HasTimestamps;

    protected $fillable = [
        'code',
        'name',
        'guard_name',
    ];

    protected $appends = [
        'status_text',
        'permission_id_by_module_keys',
    ];

    protected function casts(): array
    {
        return [
            'status' => RoleStatusEnum::class,
        ];
    }
}
