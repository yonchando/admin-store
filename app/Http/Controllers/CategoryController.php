<?php

namespace App\Http\Controllers;

use App\Http\Requests\Category\CategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use App\Services\CategoryService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CategoryController extends Controller
{
    public function __construct(
        private readonly CategoryService $categoryService,
    ) {}

    public function index(Request $request)
    {
        $categories = $this->categoryService->paginate($request->all());

        if ($request->wantsJson()) {
            return CategoryResource::collection($categories);
        }

        return Inertia::render('Category/CategoryIndex', [
            'categories' => $categories,
            'requests' => $request->all(),
        ]);
    }

    public function store(CategoryRequest $request)
    {
        $this->categoryService->store($request);

        return redirect()->route('category.index')
            ->with('success', __('lang.created_success', ['attribute' => __('lang.category')]));
    }

    public function update(CategoryRequest $request, Category $category)
    {
        $this->categoryService->update($request, $category);

        return redirect()->route('category.index')->with('success', __('lang.updated_success', ['attribute' => __('lang.category')]));
    }

    public function destroy(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
        ]);

        $this->categoryService->destroy($request->get('ids', []));

        return redirect()->back()->with('success', __('lang.deleted_success', ['attribute' => __('lang.category')]));
    }
}
