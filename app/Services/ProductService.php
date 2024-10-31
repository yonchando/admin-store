<?php

namespace App\Services;

use App\Casts\Images\ImageCast;
use App\Enums\Product\ProductStatus;
use App\Http\Requests\Product\ProductRequest;
use App\Models\Product;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Storage;

class ProductService
{
    /**
     * @return Collection<Product>
     */
    public function get(): Collection
    {
        return Product::query()
            ->applyFilter(request()->all())
            ->get();
    }

    /**
     * @return LengthAwarePaginator<Product>
     */
    public function paginate(array $filters = []): LengthAwarePaginator
    {
        return Product::query()
            ->applyFilter($filters)
            ->latest()
            ->paginate(request('perPage') ?? 20);
    }

    public function find(int $id, array $filters = []): ?Product
    {
        return Product::query()->applyFilter($filters)->find($id);
    }

    public function store(ProductRequest $request): Product
    {
        $product = new Product;

        $product->fill(collect($request->validated())->except(['slug', 'image'])->toArray());

        if ($request->hasFile('image')) {
            $file = $request->file('image');

            $path = config('paths.product_image');
            $filename = $file->hashName();
            Storage::putFileAs($path, $file, $filename);

            $product->fillJsonAttribute('json->image', [
                'filename' => $filename,
                'original_name' => $file->getClientOriginalName(),
                'path' => $path,
                'url' => Storage::url("$path/$filename"),
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
            $filename = $file->hashName();
            Storage::putFileAs($path, $file, $filename);

            $image = new ImageCast($product->json?->image);

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

    public function updateStatus(Product $product): Product
    {
        $product->status = $product->is_active ? ProductStatus::INACTIVE : ProductStatus::ACTIVE;
        $product->save();

        return $product;
    }

    public function destroy(int|array $ids): void
    {
        Product::destroy($ids);
    }
}
