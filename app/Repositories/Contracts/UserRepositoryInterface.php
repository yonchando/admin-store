<?php

namespace App\Repositories\Contracts;

use App\Http\Requests\UserRequest;
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

    public function save(UserRequest $request): User;

    public function update(UserRequest $request, User $user): User;

    public function updatePassword(Request $request, User $user): User;

    public function destroy(User $user): bool;

    public function updateStatus(User $user): bool;
}