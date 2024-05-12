<?php

namespace App\Http\Controllers;

use App\Enums\GenderEnum;
use App\Enums\User\UserStatus;
use App\Facades\Enum;
use App\Facades\Helper;
use App\Http\Requests\User\UserRequest;
use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Http\Request;
use Inertia\Inertia;

class StaffController extends Controller
{

    public function __construct(
        private readonly UserRepositoryInterface $userRepository,
    ) {
    }

    public function index(Request $request)
    {
        $staffs = $this->userRepository->paginate($request);

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
            'gender' => Enum::toSelectedForm(GenderEnum::cases(), true),
        ]);
    }

    public function store(UserRequest $request)
    {
        $this->userRepository->save($request);

        Helper::message(__('lang.created_success', ['attribute' => __('lang.staff')]));

        return redirect()->route('staff.index');
    }
    
    public function edit(User $user)
    {
        return Inertia::render('Staff/Form', [
            'staff' => $user,
            'gender' => Enum::toSelectedForm(GenderEnum::cases(), true),
        ]);
    }

    public function update(UserRequest $request, User $user)
    {
        $this->userRepository->update($request, $user);

        Helper::message(__('lang.updated_success', ['attribute' => __('lang.staff')]));

        return to_route('staff.index');
    }

    public function updateStatus(User $user)
    {
        $this->userRepository->updateStatus($user);

        Helper::message(__('lang.updated_success', ['attribute' => __('lang.staff')." ".__('lang.status')]));

        return redirect()->back();
    }

    public function destroy(User $user)
    {
        $this->userRepository->destroy($user);

        Helper::message(__('lang.deleted_success', ['attribute' => __('lang.staff')]));

        return redirect()->back();
    }
}
