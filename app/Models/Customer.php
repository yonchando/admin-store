<?php

namespace App\Models;

use App\Enums\Customer\CustomerStatusEnum;
use App\Enums\GenderEnum;
use App\Models\Concerns\Customer\HasAttributes;
use App\Models\Concerns\Customer\HasRelationships;
use App\Traits\HasTimestamps;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use HasAttributes;
    use HasFactory;
    use HasRelationships;
    use HasTimestamps;
    use SoftDeletes;

    protected $fillable = [
        'nickname',
        'phone_number',
        'email',
        'password',
        'socialize_token',
        'gender',
        'image',
        'status',
    ];

    protected $appends = [
        'gender_text',
    ];

    protected $hidden = [
        'password',
    ];

    public function casts(): array
    {
        return [
            'password' => 'hashed',
            'gender' => GenderEnum::class,
            'status' => CustomerStatusEnum::class,
        ];
    }
}
