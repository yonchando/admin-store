<?php

namespace App\Http\Controllers\Product;

use App\Facades\Helper;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Services\ProductService;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ProductOptionController extends Controller
{
    public function __construct(
        private readonly ProductService $productService,
    ) {
    }

    public function store(Request $request, Product $product)
    {
        $this->validate($request, [
            'options' => 'required|array',
            'options.*.product_option_id' => [
                'required', 'int',
                Rule::exists('product_options', 'id'),
            ],
            'options.*.product_has_option_group_id' => [
                'required', 'int',
                Rule::exists('product_has_option_groups', 'id'),
            ],
        ], [], [
            'options.*.product_option_id' => __('lang.product_option'),
            'options.*.product_has_option_group_id' => __('lang.product_option_group'),
        ]);

        $this->productService->addOptionToGroup($request);

        Helper::message(__('lang.add_success', ['attribute' => __('lang.product_option')]));

        return to_route('product.show', $product);
    }

    public function show($id)
    {
    }

    public function edit($id)
    {
    }

    public function update(Request $request, $id)
    {
    }

    public function destroy($id)
    {
    }
}
