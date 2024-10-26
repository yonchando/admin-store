<?php

namespace App\Repositories;

use App\Http\Requests\Category\CategoryRequest;
use App\Models\Category;
use App\Repositories\Contracts\CategoryRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class CategoryRepository implements CategoryRepositoryInterface
{
    public function __construct(
        private readonly Request $request,
    ) {}

    public function get(): Collection
    {
        return Category::latest()->get();
    }

    public function paginate(): LengthAwarePaginator
    {
        return Category::query()
            ->latest()
            ->paginate($this->request->get('perPage', 20));
    }

    public function store(CategoryRequest $request): Category
    {
        $category = new Category;
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
