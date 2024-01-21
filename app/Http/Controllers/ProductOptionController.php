<?php

namespace App\Http\Controllers;

use App\Facades\Helper;
use App\Http\Requests\ProductOptionRequest;
use App\Models\ProductOption;
use App\Repositories\Contracts\ProductOptionRepositoryInterface;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProductOptionController extends Controller
{
    public function __construct(
        private readonly ProductOptionRepositoryInterface $productOptionRepository,
    ) {
    }

    public function index(Request $request)
    {
        $productOptions = $this->productOptionRepository->get($request);

        return Inertia::render("ProductOption/Index", [
            'productOptions' => $productOptions,
        ]);
    }

    public function store(ProductOptionRequest $request)
    {
        $this->productOptionRepository->store($request);

        Helper::message(__('lang.created_success', ['attribute' => __('lang.product_option')]));
        return redirect()->route('product.option.index');
    }

    public function update(ProductOptionRequest $request, ProductOption $productOption)
    {
        $this->productOptionRepository->update($request, $productOption);

        Helper::message(__('lang.updated_success', ['attribute' => __('lang.product_option')]));
        return redirect()->route('product.option.index');
    }

    public function destroy(ProductOption $productOption)
    {
    }
}
