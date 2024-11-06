<?php

namespace App\Models;

use App\Enums\GenderEnum;
use App\Enums\User\UserStatusEnum;
use App\Models\Concerns\User\HasAttributes;
use App\Models\Concerns\User\HasScopes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    use HasAttributes;
    use HasScopes;

    protected $fillable = [
        'name',
        'username',
        'password',
        'is_admin',
        'gender',
        'status',
        'remember_token',
        'status_text',
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
        'status' => UserStatusEnum::class,
    ];
}
