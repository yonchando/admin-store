<?php

namespace App\Repositories;

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

    public function save(Request $request): User
    {
        // TODO: Implement save() method.
    }

    public function update(Request $request, User $user)
    {
        // TODO: Implement update() method.
    }
}