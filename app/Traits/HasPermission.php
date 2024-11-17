<?php

namespace App\Traits;

use App\Models\Module;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection as BaseCollection;

trait HasPermission
{
    public function hasPermission(int|string $permission): bool
    {
        if (is_string($permission)) {
            return $this->permissions()->where('code', $permission)->exists();
        }

        return $this->permissions()->where('id', $permission)->exists();
    }

    public function hasAnyPermissions($module, mixed $permissions)
    {
        return $this->permissions()
            ->wherePivotIn('module_id', $this->parseIds($module))
            ->whereIn('id', $this->parseIds($permissions))->exists();
    }

    public function givePermissionTo(int|string $key, mixed $permission): void
    {
        if (is_string($key)) {
            $key = Module::where('code', $key)->first()?->id;
        }

        $this->permissions()->attach($permission, ['module_id' => $key]);
    }

    public function revokePermissionTo($permissions): void
    {
        $this->permissions()->detach($permissions);
    }

    public function syncPermissions($module_id, mixed $permission): void
    {
        $permissions = [];

        foreach ($permission as $perm) {
            $permissions[$perm] = ['module_id' => $module_id];
        }

        $this->permissions()->sync($permissions);
    }

    public function getPermissionIdGroupByModule(): BaseCollection
    {
        return $this->permissions
            ->groupBy('module.module_id')
            ->map(fn ($item) => $item->pluck('id')->values());
    }

    public function permissionIdByModuleKeys(): Attribute
    {
        return Attribute::get(fn () => $this->getPermissionIdGroupByModule()->toArray());
    }

    protected function parseIds($value): array
    {
        if ($value instanceof Model) {
            return [$value->id];
        }

        if ($value instanceof Collection) {
            return $value->pluck('id')->all();
        }

        if ($value instanceof BaseCollection) {
            return $value->toArray();
        }

        return (array) $value;
    }
}
