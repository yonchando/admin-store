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

    public function filterByAndPaginate(array $filters): LengthAwarePaginator|Collection
    {
        $query = Product::query();

        $query->with([
            'category',
        ]);

        $query->filters($filters);

        return $query->paginate(@$filters['perPage'] ?? 15);
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

            $path = config('paths.product_image');
            $filename = $file->hashName();
            Storage::putFileAs($path, $file, $filename);

            $product->fillJsonAttribute('json->image', [
                'filename' => $filename,
                'original_name' => $file->getClientOriginalName(),
                'path' => $path,
                "url" => Storage::url("$path/$filename"),
            ]);
        }

        $product->save();

        return $product;
    }

    public function update(ProductRequest $request, $id): Product
    {
        $product = Product::findOrFail($id);
        $product->fill($request->except(['slug', 'image']));

        if ($request->hasFile('image')) {
            $file = $request->file('image');

            $path = config('paths.product_image');
            $filename = $file->hashName();
            Storage::putFileAs($path, $file, $filename);

            $image = $product->json->image;

            $image->originalName = $file->getClientOriginalName();
            $image->filename = $filename;
            $image->extension = $file->getClientOriginalExtension();
            $image->path = $path;
            $image->url = Storage::url("$path/$filename");

            $product->fillJsonAttribute('json->image', $image->toArray());
        }

        $product->save();

        return $product;
    }

    public function updateStatus(int $id): Product
    {
        $product = Product::findOrFail($id);
        $product->status = $product->is_active ? ProductStatus::INACTIVE : ProductStatus::ACTIVE;
        $product->save();

        return $product;
    }

    public function destroy(array|int $ids): void
    {
        Product::destroy($ids);
    }

    public function findBySlug(string $slug): Product
    {
        return Product::query()->with([
            'category',
            'productHasOptionGroups.productOptionGroup',
            'productHasOptionGroups.productHasOptions.productOption',
        ])->slug($slug)->firstOrFail();
    }
}
