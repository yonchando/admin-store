<?php

namespace App\Services;

use App\Enums\User\UserStatus;
use App\Http\Requests\User\UserRequest;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Hash;

class StaffService
{
    public function get(Request $request): Collection
    {
        return User::isNotAdmin()->filters($request)->get();
    }

    public function paginate(Request $request): LengthAwarePaginator
    {
        $query = User::query();

        $query->filters($request);

        return $query->isNotAdmin()->latest()->paginate();
    }

    public function save(UserRequest $request): User
    {

        $user = new User;

        $user->fill($request->except('password'));

        $user->password = bcrypt($request->get('password'));

        $user->save();

        return $user;
    }

    public function update(UserRequest $request, User $user): User
    {
        $user->fill($request->except('password'));

        if (! is_null($password = $request->get('password'))) {
            $user->password = bcrypt($password);
        }

        $user->save();

        return $user;
    }

    public function destroy(User $user): bool
    {
        return $user->delete();
    }

    public function updatePassword(Request $request, User $user): User
    {
        $user->password = Hash::make($request->get('password'));
        $user->save();

        return $user;
    }

    public function updateStatus(User $user): bool
    {
        $user->status = $user->status === UserStatus::ACTIVE ? UserStatus::INACTIVE : UserStatus::ACTIVE;

        return $user->save();
    }
}
