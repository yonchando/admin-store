<?php

namespace App\Services;

use App\Http\Requests\RoleRequest;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class RoleService
{
    /**
     * @return LengthAwarePaginator<Role>
     */
    public function paginate(array $filters = []): LengthAwarePaginator
    {
        return Role::default()
            ->filters($filters)
            ->latest()
            ->paginate(___($filters, 'perPage', 20));
    }

    public function store(RoleRequest $request): Role
    {
        DB::beginTransaction();

        $role = new Role($request->safe()->except('permissions'));

        $role->guard_name = config('auth.defaults.guard');

        $role->save();

        foreach (collect($request->permissions)->filter() as $key => $permission) {
            $role->givePermissionTo($key, $permission);
        }

        DB::commit();

        return $role;
    }

    public function find($id): Role
    {
        return Role::with('permissions')->findOrFail($id);
    }

    public function update(RoleRequest $request, int $id): ?Role
    {
        DB::beginTransaction();

        $role = Role::findOrFail($id);

        $role->fill($request->safe()->except('permissions'));

        $role->save();

        $role->permissions()->detach();
        foreach (collect($request->permissions)->filter() as $key => $permission) {
            $role->givePermissionTo($key, $permission);
        }

        DB::commit();

        return $role;
    }

    public function patchPermissions(Request $request, $id): Role
    {
        DB::beginTransaction();

        $role = Role::findOrFail($id);

        $role->permissions()->detach();
        foreach (collect($request->get('permissions'))->filter() as $key => $permission) {
            $role->givePermissionTo($key, $permission);
        }

        DB::commit();

        return $role;
    }

    public function destroy(mixed $ids): void
    {
        Role::destroy($ids);
    }
}
