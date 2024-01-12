<?php

namespace App\Models;

use App\Models\Concerns\Customer\HasAttributes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;
    use HasAttributes;

    protected $fillable = [
        'first_name',
        'last_name',
        'username',
        'email',
        'password',
        'city_id',
        'province_id',
        'street',
    ];

    protected $appends = [
        'name',
    ];
}
