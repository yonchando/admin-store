<?php

namespace App\Http\Controllers;

use App\Http\Requests\Category\CategoryRequest;
use App\Models\Category\Category;
use App\Repositories\Contracts\CategoryRepositoryInterface;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CategoryController extends Controller
{
    public function __construct(
        private readonly CategoryRepositoryInterface $categoryRepository,
    ) {}

    public function index(Request $request)
    {
        $categories = $this->categoryRepository->paginate();

        $sortable = $request->get('sortable', []);

        return Inertia::render('Category/Index', [
            'categories' => $categories,
            'sort' => [___($sortable, 'field') => ___($sortable, 'direction')],
        ]);
    }

    public function store(CategoryRequest $request)
    {
        $this->categoryRepository->store($request);

        return redirect()->route('category.index')
            ->with('success', __('lang.created_success', ['attribute' => __('lang.category')]));
    }

    public function update(CategoryRequest $request, Category $category)
    {
        $this->categoryRepository->update($request, $category);

        return redirect()->route('category.index')->with('success', __('lang.updated_success', ['attribute' => __('lang.category')]));
    }

    public function destroy(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
        ]);

        $this->categoryRepository->destroy($request->get('ids', []));

        return redirect()->back()->with('success', __('lang.deleted_success', ['attribute' => __('lang.category')]));
    }
}
