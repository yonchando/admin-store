<?php

namespace App\Http\Controllers\Product;

use App\Enums\Product\ProductStatus;
use App\Facades\Helper;
use App\Http\Requests\Product\OptionRequest;
use App\Http\Controllers\Controller;
use App\Http\Requests\Product\ProductFilterRequest;
use App\Http\Requests\Product\ProductOptionRequest;
use App\Http\Requests\Product\ProductRequest;
use App\Models\Product;
use App\Models\ProductHasOption;
use App\Models\ProductHasOptionGroup;
use App\Repositories\Contracts\CategoryRepositoryInterface;
use App\Repositories\Contracts\ProductHasOptionGroupRepositoryInterface;
use App\Repositories\Contracts\ProductHasOptionRepositoryInterface;
use App\Repositories\Contracts\ProductOptionGroupRepositoryInterface;
use App\Repositories\Contracts\ProductOptionRepositoryInterface;
use App\Repositories\Contracts\ProductRepositoryInterface;
use App\Services\ProductService;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Inertia\Inertia;

class ProductController extends Controller
{
    public function __construct(
        private readonly ProductRepositoryInterface $productRepository,
        private readonly CategoryRepositoryInterface $categoryRepository,
        private readonly ProductOptionGroupRepositoryInterface $productOptionGroupRepository,
        private readonly ProductOptionRepositoryInterface $productOptionRepository,
        private readonly ProductService $productService,
        private readonly ProductHasOptionRepositoryInterface $productHasOptionRepository,
    ) {
    }

    public function index(ProductFilterRequest $request)
    {
        $filters = $request->validated();

        $categories = $this->categoryRepository->get();

        $products = $this->productRepository->filterByAndPaginate($filters)->withQueryString();

        $statuses = ProductStatus::toArray();

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
    
    public function show(Request $request, $slug)
    {
        $product = $this->productRepository->findBySlug($slug);
        $groups = $this->productOptionGroupRepository->get($request);
        $options = $this->productOptionRepository->get($request);

        return Inertia::render('Product/Show', [
            'product' => $product,
            'groups' => $groups,
            'options' => $options,
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

    public function update(ProductRequest $request, $id)
    {
        $this->productRepository->update($request, $id);

        Helper::message(__('lang.updated_success', ['attribute' => __('lang.product')]));

        return redirect()->route('product.index');
    }

    public function updateStatus($id)
    {
        $this->productRepository->updateStatus(Product::find($id));

        Helper::message(__('lang.updated_success', ['attribute' => __('lang.status')]));

        return to_route('product.index');
    }

    public function destroy($id)
    {
        $this->productRepository->destroy($id);

        return redirect()->route('product.index', request()->toArray());
    }
    
    public function destroyProductOption(ProductHasOption $productHasOption)
    {
        $this->productHasOptionRepository->destroy($productHasOption->id);

        Helper::message(__('lang.deleted_success', ['attribute' => __('lang.product_option')]));

        return redirect()->back();
    }
}
