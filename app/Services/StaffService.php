<?php

namespace App\Services;

use App\Enums\Staff\StaffStatusEnum;
use App\Http\Requests\User\StaffRequest;
use App\Models\Role;
use App\Models\Staff;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Hash;

class StaffService
{
    public function get(Request $request): Collection
    {
        return Staff::isNotAdmin()->filters($request->all())->get();
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

        if ($request->get('role_ids')) {
            $staff->assignRole($request->get('role_ids'));

            $staff->roles->each(function (Role $role) use ($staff) {
                $permissions = $role->permissions->groupBy('module.module_id');

                foreach ($permissions as $key => $permission) {
                    $staff->givePermissionTo($key, $permission);
                }
            });
        }

        if ($request->get('permission_ids')) {
            foreach ($request->get('permission_ids') as $moduleId => $permission) {
                $staff->givePermissionTo($moduleId, $permission);
            }
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

        $rolePermissions = $staff->roles->flatMap(fn ($item) => $item->permissions->pluck('id'));

        if ($request->get('role_ids')) {
            foreach ($staff->roles as $role) {
                $staff->revokePermissionTo($role->permissions);
            }

            $staff->syncRole($request->get('role_ids'));

            $staff->refresh();

            $staff->roles->each(function (Role $role) use ($staff) {
                $permissions = $role->permissions->groupBy('module.module_id');

                foreach ($permissions as $key => $permission) {
                    $staff->givePermissionTo($key, $permission);
                }
            });
        }

        if ($request->get('permission_ids')) {
            $permissionIds = $staff->permissions()->whereNotIn('id', $rolePermissions->toArray())->get();
            $staff->revokePermissionTo($permissionIds);

            foreach ($request->get('permission_ids') as $moduleId => $permission) {
                $staff->givePermissionTo($moduleId, $permission);
            }
        }

        return $staff;
    }

    public function destroy(mixed $ids): bool
    {
        return Staff::destroy($ids);
    }

    public function updatePassword(Request $request, Staff $user): Staff
    {
        $user->password = Hash::make($request->get('password'));
        $user->save();

        return $user;
    }

    public function updateStatus(Staff $user): bool
    {
        $user->status = $user->status === StaffStatusEnum::ACTIVE ? StaffStatusEnum::INACTIVE : StaffStatusEnum::ACTIVE;

        return $user->save();
    }

    public function find($id): ?Staff
    {
        return Staff::findOrFail($id);
    }
}
