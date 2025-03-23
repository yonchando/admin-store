<?php

namespace App\Services\Purchase;

use App\Http\Requests\Purchase\PurchaseRequest;
use App\Models\Product;
use App\Models\PurchaseDetail;

class PurchaseDetailService
{
    /**
     * @return array<PurchaseDetail>
     */
    public function createOrEdit(PurchaseRequest $request): array
    {
        $details = [];

        $productIds = collect($request->get('products'))
            ->pluck('product_id')
            ->toArray();

        $products = Product::whereIn('id', $productIds)->get();

        $filter = collect($request->get('products'))->pluck('id')->filter();

        $purchaseDetails = PurchaseDetail::whereIn('id', $filter)->get();

        foreach ($request->get('products') as $item) {
            $qty = ___($item, 'qty');
            $product = $products->firstWhere('id', ___($item, 'product_id'));

            $detail = $purchaseDetails->firstWhere('id', ___($item, 'id'));

            if (is_null($detail)) {
                $detail = new PurchaseDetail;
            }

            $price = $product->price;

            $detail->fill([
                'product_name' => $product->product_name,
                'category_name' => $product->category?->category_name,
                'qty' => $qty,
                'price' => $price,
                'sub_total' => $qty * $product->price,
                'product_id' => $product->id,
            ]);

            $details[] = $detail;
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

    public function update(PurchaseDetail $purchaseDetail, Product $product, $qty): PurchaseDetail
    {
        $purchaseDetail->fill([
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
