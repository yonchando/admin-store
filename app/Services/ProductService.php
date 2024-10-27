<?php

namespace App\Services;

use App\Http\Requests\Product\ProductRequest;
use App\Models\Product;
use App\Models\ProductHasOption;
use App\Repositories\Contracts\ProductHasOptionGroupRepositoryInterface;
use App\Repositories\Contracts\ProductHasOptionRepositoryInterface;
use App\Repositories\Contracts\ProductRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class ProductService
{
    public function __construct(
        private readonly ProductRepositoryInterface $productRepository,
        private readonly ProductHasOptionGroupRepositoryInterface $productHasOptionGroupRepository,
        private readonly ProductHasOptionRepositoryInterface $productHasOptionRepository,
    ) {}

    public function storeProductWithProductOption(ProductRequest $request): void
    {
        DB::beginTransaction();

        $product = $this->productRepository->store($request);

        $product_options = collect($request->get('product_options'));

        if ($product_options->pluck('product_option_group_id')->filter()->isNotEmpty()) {
            $this->storeProductOption($product, $product_options);
        }

        DB::commit();
    }

    public function storeProductOption(Product $product, array|Collection $product_options): void
    {
        foreach ($product_options as $groupOption) {
            $group = $this->productHasOptionGroupRepository
                ->create($product->id, $groupOption['product_option_group_id']);

            foreach (collect($groupOption['options'])->unique('product_option_id') as $item) {
                $this->productHasOptionRepository->create(
                    $group->id,
                    $item['product_option_id'],
                    $item['price_adjustment']
                );
            }
        }
    }

    public function addOptionToGroup(Request $request): void
    {
        $options = $request->get('options', []);

        foreach ($options as $option) {
            $productHasOption = new ProductHasOption([
                'product_option_id' => $option['product_option_id'],
                'product_has_option_group_id' => $option['product_has_option_group_id'],
                'price_adjustment' => $option['price_adjustment'],
            ]);

            $productHasOption->save();
        }
    }
}
