<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;

class Permission extends Model implements Sortable
{
    use HasFactory;
    use SortableTrait;

    protected $fillable = [
        'code', 'name', 'guard_name',
    ];
}
