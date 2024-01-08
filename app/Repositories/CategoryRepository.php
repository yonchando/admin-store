<?php

namespace App\Repositories;

use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use App\Repositories\Contracts\CategoryRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class CategoryRepository implements CategoryRepositoryInterface
{

    /**
     * @inheritDoc
     */
    public function get(Request $request): Collection
    {
        return Category::get();
    }

    /**
     * @inheritDoc
     */
    public function paginate(Request $request): LengthAwarePaginator
    {
        return Category::latest()->paginate($request->get('perPage', 15));
    }

    public function store(CategoryRequest $request): Category
    {
        $category = new Category();
        $category->fill($request->validated());
        $category->slug = Str::slug($request->get('category_name'));
        $category->save();

        return $category;
    }

    public function update(CategoryRequest $request, Category $category): Category
    {

        $category->fill($request->validated());
        $category->slug = Str::slug($request->get('category_name'));
        $category->save();

        return $category;
    }

    public function destroy(Category $category): void
    {
        $category->delete();
    }
}
