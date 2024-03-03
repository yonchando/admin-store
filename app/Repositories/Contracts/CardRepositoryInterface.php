<?php

namespace App\Repositories\Contracts;

use App\Http\Requests\CardRequest;
use App\Models\Card;
use Illuminate\Database\Eloquent\Collection;

interface CardRepositoryInterface
{
    /**
     * @return Collection<Card>
     */
    public function getAll(): Collection;

    /**
     * @param  int  $id
     * @return Collection<Card>
     */
    public function getAllByUserId(int $id): Collection;

    public function findById(int $id): Card;

    public function findByNumber(string $number): Card;

    public function store(CardRequest $request): Card;

    public function update(CardRequest $request, int $id): Card;

    public function destroy(array|int $ids): void;
}
