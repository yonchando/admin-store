<?php

namespace App\Models;

use App\Models\Concerns\Category\HasScopes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    use HasScopes;

    protected $guarded = [];
}
