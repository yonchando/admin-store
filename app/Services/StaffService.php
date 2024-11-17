<?php

namespace App\Services;

use App\Http\Requests\User\StaffRequest;
use App\Models\RoleHasPermission;
use App\Models\Staff;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class StaffService
{
    public function get(Request $request): Collection
    {
        return Staff::isNotAdmin()->filters($request->all())->get();
    }

    public function find($id): ?Staff
    {
        return Staff::findOrFail($id);
    }

    public function paginate(Request $request): LengthAwarePaginator
    {
        $query = Staff::query();

        $query->filters($request->all());

        return $query->isNotAdmin()->latest()->paginate($request->get('perPage', 20));
    }

    public function store(StaffRequest $request): Staff
    {
        $staff = new Staff;
        $staff->fill($request->safe()->except(['roles', 'permissions', 'profile']));
        $staff->save();

        $staff->assignRole($request->get('role_ids'));

        $roleHasPermissions = RoleHasPermission::whereIn('role_id', $staff->roles->pluck('id'))->get();

        $permissions = collect($request->get('permission_ids', []))
            ->map(function ($permission_ids, $module_id) use ($roleHasPermissions) {
                $item = $roleHasPermissions->groupBy('module_id')->map(function ($item) {
                    return $item->pluck('permission_id')->toArray();
                });

                return array_diff($permission_ids, $item->get($module_id));
            });

        foreach ($permissions as $moduleId => $permission) {
            $staff->givePermissionTo($moduleId, $permission);
        }

        return $staff;
    }

    public function update(StaffRequest $request, Staff $staff): Staff
    {
        $staff->fill($request->safe()->except('password', 'profile', 'role_ids', 'permission_ids'));

        if (! is_null($request->get('password'))) {
            $staff->password = $request->get('password');
        }

        $staff->save();

        $staff->load('roles.permissions');

        $this->updateRolePermission($staff, $request);

        return $staff;
    }

    public function destroy(mixed $ids): bool
    {
        return Staff::destroy($ids);
    }

    public function updateRolePermission(Staff $staff, Request $request): void
    {
        $staff->syncRole($request->get('role_ids'));

        $staff->refresh();

        $staff->revokePermissionTo($staff->permissions);

        $roleHasPermissions = RoleHasPermission::whereIn('role_id', $staff->roles->pluck('id'))->get();

        $permissions = collect($request->get('permission_ids', []))
            ->map(function ($permission_ids, $module_id) use ($roleHasPermissions) {
                $item = $roleHasPermissions->groupBy('module_id')->map(function ($item) {
                    return $item->pluck('permission_id')->toArray();
                });

                return array_diff($permission_ids, $item->get($module_id) ?? []);
            });

        foreach ($permissions as $moduleId => $permission) {
            $staff->givePermissionTo($moduleId, $permission);
        }
    }
}
