<?php

namespace App\Services;

use App\Http\Requests\Category\CategoryRequest;
use App\Models\Category;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

readonly class CategoryService
{
    public function __construct(
        private Request $request,
    ) {}

    public function get(): Collection
    {
        return Category::latest()->get();
    }

    public function paginate(): LengthAwarePaginator
    {
        $query = Category::query()
            ->latest();

        $query->applyFilter(request()->all());

        return $query->paginate($this->request->get('perPage', 20));
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
        $category->updated_at = now();
        $category->save();

        return $category;
    }

    public function destroy(int|array $ids): void
    {
        Category::destroy($ids);
    }
}
