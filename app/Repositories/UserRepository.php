<?php

namespace App\Repositories;

use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class UserRepository implements Contracts\UserRepositoryInterface
{

    /**
     * @inheritDoc
     */
    public function get(Request $request): Collection
    {
        return User::isNotAdmin()->filters($request)->get();
    }

    /**
     * @inheritDoc
     */
    public function paginate(Request $request): LengthAwarePaginator
    {
        $query = User::query();

        $query->filters($request);

        return $query->isNotAdmin()->latest()->paginate();
    }

    public function findById(int $id): User
    {
        // TODO: Implement findById() method.
    }

    public function save(UserRequest $request): User
    {
        $user = new User();

        $user->fill($request->validated());

        $user->save();
       

        return $user;
    }

    public function update(UserRequest $request, User $user)
    {
        // TODO: Implement update() method.
    }

    public function destroy(User $user): bool
    {
        return $user->delete();
    }
}