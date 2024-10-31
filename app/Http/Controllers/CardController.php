<?php

namespace App\Http\Controllers;

use App\Facades\Helper;
use App\Http\Requests\CardRequest;
use App\Services\Contracts\CardRepositoryInterface;
use Inertia\Inertia;

class CardController extends Controller
{
    public function __construct(
        private readonly CardRepositoryInterface $cardRepository,
    ) {}

    public function index()
    {
        return Inertia::render('Card/Index', [
            'cards' => $this->cardRepository->getAll(),
        ]);
    }

    public function create()
    {
        return Inertia::render('Card/Form');
    }

    public function store(CardRequest $request)
    {
        $card = $this->cardRepository->store($request);

        Helper::message(__('lang.created_success', ['attribute' => __('lang.card')]));

        return to_route('card.show', $card);
    }

    public function show($id)
    {
        $card = $this->cardRepository->findById($id);

        return Inertia::render('Card/Show', compact('card'));
    }

    public function update(CardRequest $request, $id)
    {
        $this->cardRepository->update($request, $id);

        Helper::message(__('lang.updated_success', ['attribute' => __('lang.card')]));

        return back();
    }

    public function destroy($id)
    {
        $this->cardRepository->destroy($id);

        Helper::message(__('lang.deleted_success', ['attribute' => __('lang.card')]));

        return to_route('card.index');
    }
}
