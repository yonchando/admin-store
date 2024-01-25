<?php

namespace App\Services;

use App\Http\Requests\Product\ProductRequest;
use App\Models\ProductHasOption;
use App\Models\ProductHasOptionGroup;
use App\Repositories\Contracts\ProductHasOptionGroupRepositoryInterface;
use App\Repositories\Contracts\ProductHasOptionRepositoryInterface;
use App\Repositories\Contracts\ProductRepositoryInterface;

class ProductService
{

    public function __construct(
        private readonly ProductRepositoryInterface $productRepository,
        private readonly ProductHasOptionGroupRepositoryInterface $productHasOptionGroupRepository,
        private readonly ProductHasOptionRepositoryInterface $productHasOptionRepository,
    ) {
    }

    public function storeProductWithProductOption(ProductRequest $request): void
    {
        \DB::beginTransaction();

        $product = $this->productRepository->store($request);

        $product_options = collect($request->get('product_options'));

        if ($product_options->isNotEmpty()) {
            foreach ($product_options as $groupOption) {
                $group = $this->productHasOptionGroupRepository
                    ->create($product->id, $groupOption['product_option_group_id']);

                foreach ($groupOption['options'] as $item) {
                    $this->productHasOptionRepository->create(
                        $group->id,
                        $item['product_option_id'],
                        $item['price_adjustment']
                    );
                }
            }
        }

        \DB::commit();
    }
}