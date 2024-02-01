<?php

namespace App\Repositories;

use App\Enums\Product\ProductStatus;
use App\Http\Requests\Product\ProductRequest;
use App\Models\Product;
use App\Repositories\Contracts\ProductRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
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

        $query->with([
            'category',
        ]);

        $query->filters($filters);

        if (isset($filters['status'])) {
            $query->where('status', $filters['status']);
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
        return Product::query()->with([
            'category',
            'productHasOptionGroups.productOptionGroup',
            'productHasOptionGroups.productHasOptions.productOption',
        ])->find($id);
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

            $product->fillJsonAttribute('json->image', [
                'filename' => $file->getClientOriginalName(),
                'path' => "$path/$filename",
                "url" => Storage::url("$path/$filename"),
            ]);
        }

        $product->save();

        return $product;
    }

    public function update(ProductRequest $request, Product $product): Product
    {
        $product->fill($request->except(['slug', 'image']));


        if ($request->hasFile('image')) {
            $file = $request->file('image');

            $path = config('paths.product_image');
            $filename = Storage::putFileAs($path, $file, $file->hashName());

            $image = $product->json->image;

            $image->filename = $file->getClientOriginalName();
            $image->url = Storage::url("$path/$filename");
            $image->extension = $file->getClientOriginalExtension();
            $image->path = $path;

            $product->fillJsonAttribute('json->image', $image->toArray());
        }

        $product->save();

        return $product;
    }

    public function updateStatus(Product $product): Product
    {
        $product->status = $product->is_active ? ProductStatus::INACTIVE : ProductStatus::ACTIVE;
        $product->save();

        return $product;
    }

    public function destroy(Product $product): void
    {
        $product->delete();
    }
}

