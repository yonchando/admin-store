<?php

namespace App\Repository\Contracts;

use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

interface CategoryRepositoryInterface
{
    /**
     * @param Request $request
     * @return Collection<Category>
     */
    public function all(Request $request): Collection;

    /**
     * @param Request $request
     * @return LengthAwarePaginator<Category>
     */
    public function paginate(Request $request): LengthAwarePaginator;

    public function store(CategoryRequest $request): Category;

    public function update(CategoryRequest $request, Category $category): Category;

    public function destroy(Category $category): void;
}
