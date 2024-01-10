<?php

namespace App\Repositories;

use App\Http\Requests\ProductRequest;
use App\Models\Product;
use App\Repositories\Contracts\ProductRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Storage;

class ProductRepository implements ProductRepositoryInterface
{
    public function get(): Collection
    {
        return Product::query()->get();
    }

    public function paginate(): LengthAwarePaginator
    {
        return Product::query()->with(['category'])->paginate();
    }

    public function filter(array $filters): LengthAwarePaginator|Collection
    {
        $query = Product::query();

        $query->filters($filters);

        if (isset($filters['status'])) {
            $query->where('status', $filters['status']);
        } else {
            $query->active();
        }

        if (isset($filters['order_by']) && isset($filters['order_direction'])) {
            $query->where($filters['order_by'], $filters['order_direction']);
        } else {
            $query->latest();
        }

        return isset($filters['perPage']) ? $query->paginate($filters['perPage']) : $query->get();
    }

    public function find(int $id): ?Product
    {
        return Product::find($id);
    }

    public function store(ProductRequest $request): Product
    {
        $product = new Product();

        $product->fill($request->except(['slug', 'image']));

        if ($request->hasFile('image')) {
            $file = $request->file('image');

            $filename = $file->hashName();
            $path = config('paths.product_image');
            Storage::putFileAs($path, $file, $filename);

            $product->image = "$path/$filename";
        }

        $product->save();

        return $product;
    }

    public function update(ProductRequest $request, Product $product): Product
    {
        $product->fill($request->except(['slug', 'image']));


        if ($request->hasFile('image')) {
            $file = $request->file('image');

            $filename = Storage::putFileAs(config('paths.product_image'), $file, $file->hashName());

            $product->image = $filename;
        }

        $product->save();

        return $product;
    }

    public function destroy(Product $product): void
    {
        $product->delete();
    }

}