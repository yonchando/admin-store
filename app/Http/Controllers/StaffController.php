<?php

namespace App\Http\Controllers;

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
    }

    public function store(Request $request)
    {
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
    }
}
