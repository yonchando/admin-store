<?php

namespace App\Http\Controllers\Product;

use App\Facades\Helper;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductHasOptionGroup;
use App\Repositories\Contracts\ProductHasOptionGroupRepositoryInterface;
use App\Services\ProductService;
use Illuminate\Http\Request;

class ProductGroupOptionController extends Controller
{
    public function __construct(
        private readonly ProductService $productService,
        private readonly ProductHasOptionGroupRepositoryInterface $productHasGroupOptionRepository,
    ) {
    }

    public function store(Request $request, Product $product)
    {
        $this->validate($request, [
            'product_options' => 'required|array',
            'product_options.*.product_option_group_id' => 'required|int',
            'product_options.*.options.*.product_option_id' => 'required|int',
            'product_options.*.options.*.price_adjustment' => ['nullable', 'numeric', 'min:0'],
        ], [], [
            'product_options.*.product_option_group_id' => __('lang.product_option_group'),
            'product_options.*.options.*.product_option_id' => __('lang.product_option'),
            'product_options.*.options.*.price_adjustment' => __('lang.price_adjustment'),
        ]);

        $this->productService->storeProductOption($product, $request->get('product_options', []));

        Helper::message(__('lang.add_success', ['attribute' => __('lang.product_option')]));

        return redirect()->route('product.show', $product);
    }

    public function destroy(ProductHasOptionGroup $productHasOptionGroup)
    {
        $this->productHasGroupOptionRepository->destroy($productHasOptionGroup->id);

        Helper::message(__('lang.deleted_success', ['attribute' => __('lang.product_option_group')]));

        return redirect()->back();
    }
}
