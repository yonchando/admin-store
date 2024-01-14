<?php

namespace App\Http\Controllers;

use App\Enums\Gender;
use App\Facades\Helper;
use App\Http\Requests\UserRequest;
use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Database\Eloquent\Builder;
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
        ]);
    }

    public function create()
    {
        return Inertia::render('Staff/Form', [
            'gender' => Helper::enumToSelectForm(Gender::cases()),
        ]);
    }

    public function store(UserRequest $request)
    {
        $this->userRepository->save($request);

        Helper::message(__('lang.created_success', ['attribute' => __('lang.staff')]));

        return redirect()->route('staff.index');
    }

    public function show(User $user)
    {
    }

    public function edit(User $user)
    {
    }

    public function update(Request $request, User $user)
    {
    }

    public function destroy(User $user)
    {
        $this->userRepository->destroy($user);

        return redirect()->back();
    }
}
