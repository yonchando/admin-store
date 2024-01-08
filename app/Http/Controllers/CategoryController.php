<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use App\Repositories\Contracts\CategoryRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Inertia\Inertia;

class CategoryController extends Controller
{

    public function __construct(
        private readonly CategoryRepositoryInterface $categoryRepository,
    )
    {
    }

    public function index(Request $request)
    {
        $categories = $this->categoryRepository->paginate($request);

        return Inertia::render('Category/Index', [
            'categories' => $categories,
        ]);
    }

    public function store(CategoryRequest $request)
    {
        $this->categoryRepository->store($request);

        Session::flash('message', __('lang.success'));
        return redirect()->route('category.index');
    }

    public function update(CategoryRequest $request, Category $category)
    {
        $this->categoryRepository->update($request, $category);

        Session::flash('message', __('lang.success'));
        return redirect()->route('category.index');
    }

    public function destroy(Category $category)
    {
        $this->categoryRepository->destroy($category);

        Session::flash('message', __('Category Delete'));
        return redirect()->back();
    }
}
