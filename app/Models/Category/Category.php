<?php

namespace App\Models\Category;

use App\Models\Concerns\Category\HasScopes;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    use HasScopes;

    protected $fillable = [
        'category_name',
        'slug',
        'json',
    ];

    protected $casts = [
        'json' => 'object',
        'created_at' => 'date:Y-m-d | h:i A',
        'updated_at' => 'date:Y-m-d | h:i A',
    ];

    public function scopeApplyFilter(Builder $query, array $data): Builder
    {
        return (new CategoryFilter($query, $data))->apply();
    }
}
