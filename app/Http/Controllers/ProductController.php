<?php

namespace App\Http\Controllers;

use App\Enums\Product\ProductStatus;
use App\Facades\Enum;
use App\Facades\Helper;
use App\Http\Requests\Product\ProductFilterRequest;
use App\Http\Requests\Product\ProductRequest;
use App\Models\Product;
use App\Repositories\Contracts\CategoryRepositoryInterface;
use App\Repositories\Contracts\ProductOptionGroupRepositoryInterface;
use App\Repositories\Contracts\ProductOptionRepositoryInterface;
use App\Repositories\Contracts\ProductRepositoryInterface;
use App\Services\ProductService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProductController extends Controller
{
    public function __construct(
        private readonly ProductRepositoryInterface $productRepository,
        private readonly CategoryRepositoryInterface $categoryRepository,
        private readonly ProductOptionGroupRepositoryInterface $productOptionGroupRepository,
        private readonly ProductOptionRepositoryInterface $productOptionRepository,
        private readonly ProductService $productService,
    ) {
    }

    public function index(ProductFilterRequest $request)
    {
        $filters = $request->validated();

        $filters['perPage'] = $request->get('perPage', 15);

        $products = $this->productRepository->filter($filters);

        $categories = $this->categoryRepository->get();

        $statuses = Enum::toSelectedForm(ProductStatus::cases());

        return Inertia::render('Product/Index', [
            'products' => $products,
            'filters' => $filters,
            'statuses' => $statuses,
            'categories' => $categories,
        ]);
    }

    public function create(Request $request)
    {
        $categories = $this->categoryRepository->get();
        $groups = $this->productOptionGroupRepository->get($request);
        $options = $this->productOptionRepository->get($request);

        return Inertia::render('Product/Form', [
            'categories' => $categories,
            'groups' => $groups,
            'options' => $options,
        ]);
    }

    public function store(ProductRequest $request)
    {
        $this->productService->storeProductWithProductOption($request);

        Helper::message(__('lang.created_success', ['attribute' => __('lang.product')]));

        return redirect()->route('product.index');
    }

    public function show($id)
    {
        $product = $this->productRepository->find($id);

        return Inertia::render("Product/Show", [
            'product' => $product,
        ]);
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

    public function updateStatus(Product $product)
    {
        $product = $this->productRepository->updateStatus($product);

        return response()->json([
            'product' => $product,
        ]);
    }

    public function destroy(Product $product)
    {
        $this->productRepository->destroy($product);

        return redirect()->route('product.index', request()->toArray());
    }
}
