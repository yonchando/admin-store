<?php

namespace App\Repositories\Contracts;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

interface UserRepositoryInterface
{
    /**
     * @param  Request  $request
     * @return Collection<User>
     */
    public function get(Request $request): Collection;

    /**
     * @param  Request  $request
     * @return LengthAwarePaginator<User>
     */
    public function paginate(Request $request): LengthAwarePaginator;

    public function findById(int $id): User;

    public function save(Request $request): User;

    public function update(Request $request, User $user);
}