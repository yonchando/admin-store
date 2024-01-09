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
    public function get(Request $request): Collection
    {
        return Product::query()->get();
    }

    public function paginate(Request $request): LengthAwarePaginator
    {
        return Product::query()->with(['category'])
            ->paginate($request->get('perPage'));
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