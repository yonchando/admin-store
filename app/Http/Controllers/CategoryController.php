<?php

namespace App\Http\Controllers;

use App\Facades\Helper;
use App\Http\Requests\Category\CategoryRequest;
use App\Models\Category;
use App\Repositories\Contracts\CategoryRepositoryInterface;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CategoryController extends Controller
{

    public function __construct(
        private readonly CategoryRepositoryInterface $categoryRepository,
    ) {
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

        Helper::message(__('lang.created_success', ['attribute' => __('lang.category')]));

        return redirect()->route('category.index');
    }

    public function update(CategoryRequest $request, Category $category)
    {
        $this->categoryRepository->update($request, $category);

        Helper::message(__('lang.updated_success', ['attribute' => __('lang.category')]));

        return redirect()->route('category.index');
    }

    public function destroy(Category $category)
    {
        $this->categoryRepository->destroy($category);

        Helper::message(__('lang.deleted_success', ['attribute' => __('lang.category')]));

        return redirect()->back();
    }
}
