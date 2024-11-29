<?php

namespace App\Models;

use App\Enums\Module\ModuleStatusEnum;
use App\Filters\Module\ModuleFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;

class Module extends Model implements Sortable
{
    use HasFactory;
    use SortableTrait;

    protected $fillable = [
        'code',
        'name',
        'status',
    ];

    protected $appends = [
        'status_text',
    ];

    protected function casts(): array
    {
        return [
            'status' => ModuleStatusEnum::class,
            'created_at' => 'datetime:Y-m-d h:i A',
            'updated_at' => 'datetime:Y-m-d h:i A',
        ];
    }

    public function scopeFilters(Builder $builder, array $filters): Builder
    {
        return new ModuleFilter($builder, $filters)->apply();
    }

    public function givePermissionTo(mixed $permissions): void
    {
        $this->permissions()->attach($permissions);
    }

    public function syncPermission(mixed $permissions): void
    {
        $this->permissions()->sync($permissions);
    }

    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(Permission::class, 'module_has_permissions');
    }
}
