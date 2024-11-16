<?php

namespace App\Http\Controllers;

use App\Enums\GenderEnum;
use App\Enums\Staff\StaffStatusEnum;
use App\Http\Requests\User\StaffRequest;
use App\Models\Staff;
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
            'filters' => $request->toArray(),
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

    public function edit($id)
    {
        $user = $this->staffService->find($id);

        return Inertia::render('Staff/StaffForm', [
            'staff' => $user,
            'gender' => GenderEnum::toArray(),
            'statuses' => StaffStatusEnum::toArray(),
        ]);
    }

    public function update(StaffRequest $request, $id)
    {
        $user = $this->staffService->find($id);

        $this->staffService->update($request, $user);

        return to_route('staff.index')
            ->with('success', __('lang.updated_success', ['attribute' => __('lang.staff')]));
    }

    public function updateStatus(Staff $user)
    {
        $this->staffService->updateStatus($user);

        return redirect()->back()
            ->with('success', __('lang.updated_success', ['attribute' => __('lang.staff')]));
    }

    public function destroy(Request $request)
    {
        $request->validate([
            'ids' => ['required', 'array'],
        ]);

        $ids = $request->get('ids');

        $this->staffService->destroy($ids);

        return redirect()->back()
            ->with('success', __('lang.deleted_success', ['attribute' => __('lang.staff')]));
    }
}
