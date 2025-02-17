<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ApiAccessToken extends Model
{
    use HasFactory;
    use SoftDeletes;

    public const string DELETED_AT = 'revoked_at';

    protected $fillable = [
        'name',
        'token',
        'last_used_at',
        'expires_at',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'last_used_at' => 'datetime',
    ];
}
