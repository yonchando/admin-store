<?php

namespace App\Models;

use App\Enums\Module\ModuleStatusEnum;
use App\Filters\Module\ModuleFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Module extends Model
{
    use HasFactory;

    protected $fillable = [
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
        return (new ModuleFilter($builder, $filters))->apply();
    }

    public function givePermissionTo(mixed $permissions): void
    {
        $this->permissions()->attach($permissions);
    }

    public function syncPermission(mixed $permissions): void
    {
        $this->permissions()->sync($permissions);
    }

    public function statusText(): Attribute
    {
        return Attribute::get(fn () => \Lang::get('lang.'.$this->status->value));
    }

    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(Permission::class, 'module_has_permissions');
    }
}
