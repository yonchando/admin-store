<?php

namespace App\Models;

use App\Models\Concerns\HasScopes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
    use HasFactory;
    use HasScopes;

    protected $fillable = [
        'name',
        'status',
    ];
}
