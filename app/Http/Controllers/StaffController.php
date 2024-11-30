<?php

namespace App\Http\Controllers;

use App\Enums\GenderEnum;
use App\Enums\Staff\StaffStatusEnum;
use App\Http\Requests\User\StaffRequest;
use App\Services\RoleService;
use App\Services\StaffService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class StaffController extends Controller
{
    public function __construct(
        private readonly StaffService $staffService,
        private readonly RoleService $roleService,
    ) {}

    public function index(Request $request)
    {
        $staffs = $this->staffService->paginate($request);

        return Inertia::render('Staff/StaffIndex', [
            'staffs' => $staffs,
            'gender' => GenderEnum::toArray(),
            'statuses' => StaffStatusEnum::toArray(),
            'requests' => $request->all(),
        ]);
    }

    public function create()
    {
        return Inertia::render('Staff/StaffForm', [
            'gender' => GenderEnum::toArray(),
            'statuses' => StaffStatusEnum::toArray(),
            'roles' => $this->roleService->paginate([
                'includes' => ['permissions'],
            ]),
        ]);
    }

    public function store(StaffRequest $request)
    {
        $this->staffService->store($request);

        return redirect()->route('staff.index')
            ->with('success', __('lang.created_success', ['attribute' => __('lang.staff')]));
    }

    public function show($id)
    {
        $staff = $this->staffService->find($id);
        $staff->load(['roles']);

        return Inertia::render('Staff/StaffShow', [
            'staff' => $staff,
            'roles' => $this->roleService->paginate([
                'includes' => [
                    'permissions' => function ($query) {
                        return $query->ordered();
                    },
                ],
            ]),
        ]);
    }

    public function edit($id)
    {
        $staff = $this->staffService->find($id);
        $staff->load(['roles']);

        return Inertia::render('Staff/StaffForm', [
            'staff' => $staff,
            'gender' => GenderEnum::toArray(),
            'statuses' => StaffStatusEnum::toArray(),
            'roles' => $this->roleService->paginate([
                'includes' => [
                    'permissions' => function ($query) {
                        return $query->ordered();
                    }],
            ]),
        ]);
    }

    public function update(StaffRequest $request, $id)
    {
        $user = $this->staffService->find($id);

        $this->staffService->update($request, $user);

        return to_route('staff.index')
            ->with('success', __('lang.updated_success', ['attribute' => __('lang.staff')]));
    }

    public function updateRolePermission(Request $request, $id)
    {
        $request->validate([
            'role_ids' => ['nullable', 'array'],
            'role_ids.*' => 'exists:roles,id',
            'permission_ids' => ['nullable', 'array'],
        ]);

        $user = $this->staffService->find($id);

        $this->staffService->updateRolePermission($user, $request);

        return to_route('staff.show', $id)
            ->with('success', __('lang.updated_success', ['attribute' => __('lang.staff')]));
    }

    public function destroy(Request $request)
    {
        $request->validate([
            'ids' => ['required', 'array'],
        ]);

        $ids = $request->get('ids');

        $this->staffService->destroy($ids);

        return redirect()->route('staff.index')
            ->with('success', __('lang.deleted_success', ['attribute' => __('lang.staff')]));
    }
}
