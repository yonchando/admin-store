<?php

namespace App\Repositories\Contracts;

use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
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

    public function destroy(Category $category): void;
}
