<?php

namespace App\Http\Controllers;

use App\Facades\Helper;
use App\Http\Requests\CardRequest;
use App\Services\CardService;
use Inertia\Inertia;

class CardController extends Controller
{
    public function __construct(
        private readonly CardService $cardService,
    ) {}

    public function index()
    {
        return Inertia::render('Card/Index', [
            'cards' => $this->cardService->getAll(),
        ]);
    }

    public function create()
    {
        return Inertia::render('Card/Form');
    }

    public function store(CardRequest $request)
    {
        $card = $this->cardService->store($request);

        Helper::message(__('lang.created_success', ['attribute' => __('lang.card')]));

        return to_route('card.show', $card);
    }

    public function show($id)
    {
        $card = $this->cardService->findById($id);

        return Inertia::render('Card/Show', compact('card'));
    }

    public function update(CardRequest $request, $id)
    {
        $this->cardService->update($request, $id);

        Helper::message(__('lang.updated_success', ['attribute' => __('lang.card')]));

        return back();
    }

    public function destroy($id)
    {
        $this->cardService->destroy($id);

        Helper::message(__('lang.deleted_success', ['attribute' => __('lang.card')]));

        return to_route('card.index');
    }
}
