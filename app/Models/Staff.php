<?php

namespace App\Models;

use App\Enums\GenderEnum;
use App\Enums\Staff\StaffStatusEnum;
use App\Models\Concerns\Staff\HasAttributes;
use App\Models\Concerns\Staff\HasRelationships;
use App\Models\Concerns\Staff\HasScopes;
use App\Traits\HasPermission;
use App\Traits\HasTimestamps;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Staff extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    use HasAttributes;
    use HasPermission;
    use HasRelationships;
    use HasScopes;
    use HasTimestamps;
    use SoftDeletes;

    protected $table = 'staffs';

    protected $fillable = [
        'name',
        'username',
        'password',
        'is_admin',
        'gender',
        'status',
        'remember_token',
        'position',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'is_admin',
    ];

    protected $casts = [
        'password' => 'hashed',
        'is_admin' => 'boolean',
        'gender' => GenderEnum::class,
        'status' => StaffStatusEnum::class,
    ];

    protected $appends = ['permission_id_by_module_keys'];

    public function assignRole(mixed $roles): void
    {
        $this->roles()->attach($roles);
    }

    public function syncRole(mixed $roles): void
    {
        $this->roles()->sync($roles);
    }
}
