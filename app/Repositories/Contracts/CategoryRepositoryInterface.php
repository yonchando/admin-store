<?php

namespace App\Repositories\Contracts;

use App\Http\Requests\Category\CategoryRequest;
use App\Models\Category\Category;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

interface CategoryRepositoryInterface
{
    /**
     * @return Collection<Category>
     */
    public function get(): Collection;

    /**
     * @return LengthAwarePaginator<Category>
     */
    public function paginate(): LengthAwarePaginator;

    public function store(CategoryRequest $request): Category;

    public function update(CategoryRequest $request, Category $category): Category;

    public function destroy(int|array $ids): void;
}
