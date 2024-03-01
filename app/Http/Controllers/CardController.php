<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class CardController extends Controller
{
    public function index()
    {
        return Inertia::render('Card/Index');
    }

    public function create()
    {
        return Inertia::render('Card/Form');
    }

    public function store(Request $request)
    {
    }

    public function show($id)
    {
        return Inertia::render('Card/Show');
    }

    public function edit($id)
    {
        return Inertia::render('Card/Form');
    }

    public function update(Request $request, $id)
    {
        return back();
    }

    public function destroy($id)
    {
        return to_route('card.index');
    }
}
