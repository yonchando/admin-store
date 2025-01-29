<?php

namespace App\Services;

use App\Casts\Images\ImageCast;
use App\Casts\Product\ProductJson;
use App\Enums\Product\ProductStatusEnum;
use App\Http\Requests\Product\ProductRequest;
use App\Models\Product;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\UploadedFile;
use Storage;

class ProductService
{
    /**
     * @return Collection<Product>
     */
    public function get(array $filters = []): Collection
    {
        return Product::query()
            ->filters($filters)
            ->get();
    }

    /**
     * @return LengthAwarePaginator<Product>
     */
    public function paginate(array $filters = []): LengthAwarePaginator
    {
        return Product::query()
            ->filters($filters)
            ->latest()
            ->paginate(perPage: request('perPage'), pageName: request('pageName', 'page'));
    }

    public function find(int $id, array $filters = []): ?Product
    {
        return Product::query()->filters($filters)->findOrFail($id);
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
            $image = $this->uploadImage($request->file('image'), $product->json?->image);
            $product->json->image = $image;
        }

        $product->save();

        return $product;
    }

    public function updateStatus(Product $product): Product
    {
        $product->status = $product->is_active ? ProductStatusEnum::INACTIVE : ProductStatusEnum::ACTIVE;
        $product->save();

        return $product;
    }

    public function destroy(int|array $ids): void
    {
        Product::destroy($ids);
    }

    public function upload(Product $product, UploadedFile $file): bool
    {
        $image = $this->uploadImage($file, $product->json?->image);
        $json = $product->json ?? new ProductJson;
        $json->image = $image;
        $product->json = $json;

        return $product->save();
    }

    private function uploadImage(UploadedFile $file, ?ImageCast $defaultImage = null): ImageCast
    {
        $path = config('paths.product_image');
        $filename = $file->hashName();
        Storage::putFileAs($path, $file, $filename);

        $image = new ImageCast($defaultImage?->toArray());

        $image->originalName = $file->getClientOriginalName();
        $image->filename = $filename;
        $image->extension = $file->getClientOriginalExtension();
        $image->path = $path;
        $image->url = Storage::url("$path/$filename");

        return $image;
    }
}
