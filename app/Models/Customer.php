<?php

namespace App\Models;

use App\Casts\Images\ImageCast;
use App\Enums\Customer\CustomerStatusEnum;
use App\Enums\GenderEnum;
use App\Models\Concerns\Customer\HasAttributes;
use App\Models\Concerns\Customer\HasRelationships;
use App\Models\Concerns\Customer\HasScopes;
use App\Traits\HasTimestamps;
use App\Traits\Paginator;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use HasAttributes;
    use HasFactory;
    use HasRelationships;
    use HasScopes;
    use HasTimestamps;
    use Paginator;
    use SoftDeletes;

    protected $fillable = [
        'name',
        'phone_number',
        'email',
        'password',
        'socialize_token',
        'gender',
        'profile',
        'status',
    ];

    protected $hidden = [
        'password',
        'socialize_token',
    ];

    public function casts(): array
    {
        return [
            'password' => 'hashed',
            'gender' => GenderEnum::class,
            'status' => CustomerStatusEnum::class,
            'profile' => ImageCast::class,
            'phone_number' => 'string'
        ];
    }
}
