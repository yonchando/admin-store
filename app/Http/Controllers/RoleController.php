<?php

namespace App\Http\Controllers;

use App\Enums\Role\RoleStatusEnum;
use App\Http\Requests\RoleRequest;
use App\Services\ModuleService;
use App\Services\RoleService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class RoleController extends Controller
{
    public function __construct(
        private readonly RoleService $roleService,
        private readonly ModuleService $moduleService,
    ) {}

    public function index(Request $request)
    {
        return Inertia::render('Role/RoleIndex', [
            'roles' => $this->roleService->paginate($request->all()),
            'requests' => $request->all(),
        ]);
    }

    public function create()
    {
        return Inertia::render('Role/RoleForm', [
            'statuses' => RoleStatusEnum::toArray(),
            'modules' => $this->moduleService->get(),
        ]);
    }

    public function store(RoleRequest $request)
    {
        $this->roleService->store($request);

        return to_route('role.index')->with('success', __('lang.created_success', ['attribute' => __('lang.role')]));
    }

    public function show($id)
    {
        $role = $this->roleService->find($id);

        return Inertia::render('Role/RoleShow', [
            'role' => $role,
            'permissions' => $role->getPermissionIdGroupByModule(),
        ]);
    }

    public function edit($id)
    {
        $role = $this->roleService->find($id);
        $permissions = $role->getPermissionIdGroupByModule()->toArray();

        return Inertia::render('Role/RoleForm', [
            'statuses' => RoleStatusEnum::toArray(),
            'modules' => $this->moduleService->get(),
            'role' => $role,
            'permissions' => $permissions,
        ]);
    }

    public function update(RoleRequest $request, $id)
    {
        $this->roleService->update($request, $id);

        return to_route('role.show', $id)->with('success', __('lang.updated_success', ['attribute' => __('lang.role')]));
    }

    public function patchPermissions(Request $request, $id)
    {
        $request->validate([
            'permissions' => ['nullable', 'array'],
        ]);

        $this->roleService->patchPermissions($request, $id);

        return back()->with('success', __('lang.updated_success', ['attribute' => 'Permissions']));
    }

    public function destroy(Request $request)
    {
        $request->validate([
            'ids' => ['required', 'array'],
            'ids.*' => 'exists:roles,id',
        ]);

        $this->roleService->destroy($request->get('ids'));

        return to_route('role.index')
            ->with('success', __('lang.deleted_success', ['attribute' => __('lang.role')]));
    }
}
