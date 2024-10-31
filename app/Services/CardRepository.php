<?php

namespace App\Services;

use App\Http\Requests\CardRequest;
use App\Models\Card;
use Illuminate\Database\Eloquent\Collection;

class CardRepository implements Contracts\CardRepositoryInterface
{
    /**
     * {@inheritDoc}
     */
    public function getAll(): Collection
    {
        return Card::get();
    }

    /**
     * {@inheritDoc}
     */
    public function getAllByUserId(int $id): Collection
    {
        return Card::get();
    }

    public function findById(int $id): Card
    {
        return Card::findOrFail($id);
    }

    public function findByNumber(string $number): Card
    {
        return Card::where('number', $number)->firstOrFail();
    }

    public function store(CardRequest $request): Card
    {
        $data = $request->validated();
        $data['number'] = rand(0000000000000000, 9999999999999999);

        return Card::create($data);
    }

    public function update(CardRequest $request, int $id): Card
    {
        $card = Card::findOrFail($id);

        $card->fill($request->validated());
        $card->save();

        return $card;
    }

    public function destroy(array|int $ids): void
    {
        Card::destroy($ids);
    }
}
