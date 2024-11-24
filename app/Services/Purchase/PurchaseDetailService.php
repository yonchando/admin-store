<?php

namespace App\Services\Purchase;

use App\Http\Requests\PurchaseRequest;
use App\Models\Product;
use App\Models\PurchaseDetail;
use Illuminate\Support\Collection;

class PurchaseDetailService
{
    /**
     * @return Collection<PurchaseDetail>
     */
    public function create(PurchaseRequest $request): Collection
    {
        $details = collect();

        $products = Product::whereIn('id', collect($request->get('products'))->pluck('product_id')->toArray())->get();

        foreach ($request->get('products') as $item) {

            $qty = ___($item, 'qty');
            $product = $products->firstWhere('id', ___($item, 'product_id'));

            $details[] = new PurchaseDetail([
                'product_name' => $product->product_name,
                'category_name' => $product->category?->category_name,
                'qty' => $qty,
                'price' => $product->price,
                'sub_total' => $qty * $product->price,
                'product_id' => $product->id,
            ]);
        }

        return $details;
    }

    public function store(Product $product, $qty): PurchaseDetail
    {
        $purchaseDetail = new PurchaseDetail([
            'product_name' => $product->product_name,
            'qty' => $qty,
            'sub_total' => $qty * $product->price,
            'ref_product_id' => $product->id,
            'category_name' => $product->category?->category_name,
        ]);

        $purchaseDetail->save();

        return $purchaseDetail;
    }
}
