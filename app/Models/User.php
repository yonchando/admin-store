<?php

namespace App\Models;

use App\Enums\GenderEnum;
use App\Enums\User\UserStatus;
use App\Models\Concerns\User\HasAttributes;
use App\Models\Concerns\User\HasScopes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    use HasScopes;
    use HasAttributes;

    protected $fillable = [
        'name',
        'username',
        'password',
        'role',
        'is_admin',
        'gender',
        'remember_token',
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
        'status' => UserStatus::class,
    ];

    protected $appends = [
        'status_text',
    ];
}
