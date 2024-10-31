<?php

namespace App\Http\Controllers;

use App\Enums\Product\ProductStatus;
use App\Http\Requests\Product\ProductRequest;
use App\Models\Product;
use App\Services\ProductService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProductController extends Controller
{
    public function __construct(
        private readonly ProductService $productService,
    ) {}

    public function index(Request $request)
    {
        $request->merge([
            'includes' => 'category',
        ]);

        $products = $this->productService->paginate($request->all());

        $statuses = ProductStatus::toArray();

        return Inertia::render('Product/ProductIndex', [
            'products' => $products,
            'statuses' => fn () => $statuses,
            'requests' => $request->except('includes'),
        ]);
    }

    public function create()
    {
        $statuses = ProductStatus::toArray();

        return Inertia::render('Product/ProductForm', [
            'statuses' => $statuses,
        ]);
    }

    public function store(ProductRequest $request)
    {
        $this->productService->store($request);

        return redirect()->route('product.index')
            ->with('success', __('lang.created_success', ['attribute' => __('lang.product')]));
    }

    public function show($id)
    {
        $product = $this->productService->find($id, [
            'includes' => ['category'],
        ]);

        return Inertia::render('Product/ProductShow', [
            'product' => $product,
        ]);
    }

    public function edit($id)
    {
        $product = $this->productService->find($id);

        if (is_null($product)) {
            abort(404);
        }

        $statuses = ProductStatus::toArray();

        return Inertia::render('Product/ProductForm', [
            'product' => $product,
            'statuses' => $statuses,
        ]);
    }

    public function update(ProductRequest $request, $id)
    {
        $product = Product::find($id);
        $this->productService->update($request, $product);

        return redirect()->route('product.index')
            ->with('success', __('lang.updated_success', ['attribute' => __('lang.product')]));
    }

    public function updateStatus($id)
    {
        $this->productService->updateStatus(Product::find($id));

        return to_route('product.index')
            ->with('success', __('lang.updated_success', ['attribute' => __('lang.status')]));
    }

    public function destroy(Request $request)
    {
        $ids = $request->get('ids', []);

        $this->productService->destroy($ids);

        return redirect()->route('product.index', request()->toArray());
    }
}
