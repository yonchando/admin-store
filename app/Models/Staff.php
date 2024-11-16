<?php

namespace App\Models;

use App\Enums\GenderEnum;
use App\Enums\Staff\StaffStatusEnum;
use App\Models\Concerns\Staff\HasAttributes;
use App\Models\Concerns\Staff\HasRelationships;
use App\Models\Concerns\Staff\HasScopes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Staff extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    use HasAttributes;
    use HasRelationships;
    use HasScopes;

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

    protected $appends = ['status_text'];

    public function assignRole(mixed $roles): void
    {
        $this->roles()->attach($roles);
    }

    public function syncRole(mixed $roles): void
    {
        $this->roles()->sync($roles);
    }

    public function givePermissionTo($module_id, mixed $permission): void
    {
        $this->permissions()->attach($permission, ['module_id' => $module_id]);
    }

    public function revokePermissionTo($permissions): void
    {
        $this->permissions()->detach($permissions);
    }

    public function syncPermissions($module_id, mixed $permission): void
    {
        $this->permissions()->detach($this->permissions);

        $this->givePermissionTo($module_id, $permission);
    }
}
