<?php

namespace App\Http\Controllers;

use App\Enums\Product\ProductStatus;
use App\Facades\Helper;
use App\Http\Requests\ProductRequest;
use App\Models\Product;
use App\Repositories\Contracts\CategoryRepositoryInterface;
use App\Repositories\Contracts\ProductRepositoryInterface;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProductController extends Controller
{
    public function __construct(
        private readonly ProductRepositoryInterface $productRepository,
        private readonly CategoryRepositoryInterface $categoryRepository,
    ) {
    }

    public function index(Request $request)
    {
        $filters = $request->only([
            'category_id',
            'search',
            'min_price',
            'max_price',
            'status',
        ]);

        $filters['perPage'] = $request->get('perPage', 15);

        $products = $this->productRepository->filter($filters);

        $categories = $this->categoryRepository->get();

        $statuses = ProductStatus::toArray();

        return Inertia::render('Product/Index', [
            'products' => $products,
            'filters' => $filters,
            'statuses' => $statuses,
            'categories' => $categories,
        ]);
    }

    public function create()
    {
        $categories = $this->categoryRepository->get();

        return Inertia::render('Product/Form', [
            'categories' => $categories,
        ]);
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
        $categories = $this->categoryRepository->get();

        return Inertia::render('Product/Form', [
            'categories' => $categories,
            'product' => $product,
        ]);
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
