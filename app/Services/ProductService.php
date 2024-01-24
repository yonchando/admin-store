<?php

namespace App\Services;

use App\Http\Requests\Product\ProductRequest;
use App\Models\ProductHasOption;
use App\Models\ProductHasOptionGroup;
use App\Repositories\Contracts\ProductRepositoryInterface;

class ProductService
{

    public function __construct(
        private readonly ProductRepositoryInterface $productRepository,
    ) {
    }

    public function storeProductWithProductOption(ProductRequest $request): void
    {
        $product = $this->productRepository->store($request);

        $product_options = collect($request->get('product_options'));

        if ($product_options->isNotEmpty()) {
            foreach ($product_options as $groupOption) {
                $group = ProductHasOptionGroup::create([
                    'product_option_group_id' => $groupOption['product_option_group_id'],
                    'product_id' => $product->id,
                ]);

                foreach ($groupOption['options'] as $item) {
                    ProductHasOption::create([
                        'product_has_option_group_id' => $group->id,
                        'product_option_id' => $item['product_option_id'],
                        'price_adjustment' => $item['price_adjustment'],
                    ]);
                }
            }
        }
    }
}