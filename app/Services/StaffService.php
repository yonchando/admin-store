<?php

namespace App\Services;

use App\Enums\User\UserStatusEnum;
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
        return User::isNotAdmin()->filters($request->all())->get();
    }

    public function paginate(Request $request): LengthAwarePaginator
    {
        $query = User::query();

        $query->filters($request->all());

        return $query->isNotAdmin()->latest()->paginate();
    }

    public function save(UserRequest $request): User
    {
        $user = new User;
        $user->fill($request->except('profile'));
        $user->save();

        return $user;
    }

    public function update(UserRequest $request, User $user): User
    {
        $user->fill($request->except('password', 'profile'));

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
        $user->status = $user->status === UserStatusEnum::ACTIVE ? UserStatusEnum::INACTIVE : UserStatusEnum::ACTIVE;

        return $user->save();
    }

    public function find($id): ?User
    {
        return User::findOrFail($id);
    }
}
