<?php

namespace App\Models;

use App\Filters\Category\CategoryFilter;
use App\Models\Concerns\Category\HasRelationships;
use App\Models\Concerns\Category\HasScopes;
use App\Traits\HasTimestamps;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    use HasRelationships;
    use HasScopes;
    use HasTimestamps;

    protected $fillable = [
        'category_name',
        'parent_id',
        'slug',
        'json',
    ];

    protected $casts = [
        'json' => 'object',
    ];

    public function scopeFilters(Builder $query, array $data): Builder
    {
        return new CategoryFilter($query, $data)->apply();
    }
}
