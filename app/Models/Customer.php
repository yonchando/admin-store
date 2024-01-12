<?php

namespace App\Models;

use App\Models\Concerns\Customer\HasAttributes;
use App\Models\Concerns\Customer\HasRelationships;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;
    use HasAttributes;
    use HasRelationships;

    protected $fillable = [
        'first_name',
        'last_name',
        'phone',
        'email',
        'password',
        'verified_at',
        'gender',
        'city_id',
        'province_id',
        'street',
    ];

    protected $appends = [
        'name',
        'gender_text',
    ];

    protected $hidden = [
        'password',
    ];
}
