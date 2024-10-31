<?php

namespace App\Http\Controllers;

use App\Enums\GenderEnum;
use App\Enums\User\UserStatus;
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

        return Inertia::render('Staff/Index', [
            'staffs' => $staffs,
            'gender' => GenderEnum::toArray(),
            'statuses' => UserStatus::toArray(),
            'filters' => $request->toArray(),
        ]);
    }

    public function create()
    {
        return Inertia::render('Staff/Form', [
            'gender' => GenderEnum::toArray(),
        ]);
    }

    public function store(UserRequest $request)
    {
        $this->staffService->save($request);

        return redirect()->route('staff.index')
            ->with('success', __('lang.created_success', ['attribute' => __('lang.staff')]));
    }

    public function edit(User $user)
    {
        return Inertia::render('Staff/Form', [
            'staff' => $user,
            'gender' => GenderEnum::toArray(),
        ]);
    }

    public function update(UserRequest $request, User $user)
    {
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
