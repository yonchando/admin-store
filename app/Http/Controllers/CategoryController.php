<?php

namespace App\Http\Controllers;

use App\Http\Requests\Category\CategoryRequest;
use App\Http\Resources\CategoryResource;
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
        if ($request->wantsJson()) {
            if ($request->has('perPage')) {
                return CategoryResource::collection($this->categoryService->paginate($request->all()));
            } else {
                return CategoryResource::collection($this->categoryService->get($request->all()));
            }
        }

        $request->merge([
            'parentIdNull' => true,
            'parent' => $request->get('parent')
        ]);

        $categories = $this->categoryService->paginate($request->all());

        return Inertia::render('Category/CategoryIndex', [
            'categories' => CategoryResource::collection($categories),
            'requests' => $request->all(),
        ]);
    }

    public function store(CategoryRequest $request)
    {
        $this->categoryService->store($request);

        return redirect()->route('category.index')
            ->with('success', __('lang.created_success', ['attribute' => __('lang.category')]));
    }

    public function update(CategoryRequest $request, $id)
    {
        $category = $this->categoryService->find($id);
        $this->categoryService->update($request, $category);

        return redirect()->route('category.index')->with('success',
            __('lang.updated_success', ['attribute' => __('lang.category')]));
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
