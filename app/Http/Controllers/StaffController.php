<?php

namespace App\Http\Controllers;

use App\Enums\GenderEnum;
use App\Enums\User\UserStatusEnum;
use App\Http\Requests\User\UserRequest;
use App\Models\User;
use App\Services\StaffService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class StaffController extends Controller
{
    public function __construct(
        private readonly StaffService $staffService,
    ) {}

    public function index(Request $request)
    {
        $staffs = $this->staffService->paginate($request);

        return Inertia::render('Staff/StaffIndex', [
            'staffs' => $staffs,
            'gender' => GenderEnum::toArray(),
            'statuses' => UserStatusEnum::toArray(),
            'filters' => $request->toArray(),
        ]);
    }

    public function create()
    {
        return Inertia::render('Staff/StaffForm', [
            'gender' => GenderEnum::toArray(),
            'statuses' => UserStatusEnum::toArray(),
        ]);
    }

    public function store(UserRequest $request)
    {
        $this->staffService->save($request);

        return redirect()->route('staff.index')
            ->with('success', __('lang.created_success', ['attribute' => __('lang.staff')]));
    }

    public function edit($id)
    {
        $user = $this->staffService->find($id);

        return Inertia::render('Staff/StaffForm', [
            'staff' => $user,
            'gender' => GenderEnum::toArray(),
            'statuses' => UserStatusEnum::toArray(),
        ]);
    }

    public function update(UserRequest $request, $id)
    {
        $user = $this->staffService->find($id);

        $this->staffService->update($request, $user);

        return to_route('staff.index')
            ->with('success', __('lang.updated_success', ['attribute' => __('lang.staff')]));
    }

    public function updateStatus(User $user)
    {
        $this->staffService->updateStatus($user);

        return redirect()->back()
            ->with('success', __('lang.updated_success', ['attribute' => __('lang.staff')]));
    }

    public function destroy(User $user)
    {
        $this->staffService->destroy($user);

        return redirect()->back()
            ->with('success', __('lang.deleted_success', ['attribute' => __('lang.staff')]));
    }
}
