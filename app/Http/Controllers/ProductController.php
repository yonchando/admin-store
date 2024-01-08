<?php

namespace App\Http\Controllers;

use App\Facades\Helper;
use App\Http\Requests\ProductRequest;
use App\Models\Product;
use App\Repositories\Contracts\ProductRepositoryInterface;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProductController extends Controller
{


    public function __construct(
        private readonly ProductRepositoryInterface $productRepository,
    )
    {
    }

    public function index(Request $request)
    {
        $products = $this->productRepository->paginate($request);
        return Inertia::render('Product/Index', [
            'products' => $products,
        ]);
    }

    public function create()
    {
    }

    public function store(ProductRequest $request)
    {
        $this->productRepository->store($request);

        Helper::message(__('lang.created_success', ['attribute' => __('lang.product')]));
        return redirect()->route('product.index');
    }

    public function show(Product $product)
    {
    }

    public function edit(Product $product)
    {
    }

    public function update(ProductRequest $request, Product $product)
    {
        $this->productRepository->update($request, $product);

        Helper::message(__('lang.updated_success', ['attribute' => __('lang.product')]));
        return redirect()->route('product.index');
    }

    public function destroy(Product $product)
    {
        $this->productRepository->destroy($product);
        return redirect()->route('product.index', request()->toArray());
    }
}
