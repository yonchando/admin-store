<?php

namespace App\Http\Controllers;

use App\Enums\Product\ProductStatus;
use App\Facades\Enum;
use App\Facades\Helper;
use App\Http\Requests\Product\ProductFilterRequest;
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
        private readonly ProductHasOptionGroupRepositoryInterface $productHasOptionGroupRepository,
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
            'request' => $request->all()
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

    public function storeProductOption(Request $request, Product $product)
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

    public function storeOption(Request $request, Product $product)
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

    public function update(ProductRequest $request, Product $product)
    {
        $this->productRepository->update($request, $product);

        Helper::message(__('lang.updated_success', ['attribute' => __('lang.product')]));

        return redirect()->route('product.index');
    }

    public function updateStatus($id)
    {
        $product = $this->productRepository->updateStatus(Product::find($id));

        Helper::message(__('lang.updated_success', ['attribute' => __('lang.status')]));

        return to_route('product.index');
    }

    public function destroy(Product $product)
    {
        $this->productRepository->destroy($product);

        return redirect()->route('product.index', request()->toArray());
    }

    public function destroyProductOptionGroup(ProductHasOptionGroup $productHasOptionGroup)
    {
        $this->productHasOptionGroupRepository->destroy($productHasOptionGroup->id);

        Helper::message(__('lang.deleted_success', ['attribute' => __('lang.product_option_group')]));

        return redirect()->back();
    }

    public function destroyProductOption(ProductHasOption $productHasOption)
    {
        $this->productHasOptionRepository->destroy($productHasOption->id);

        Helper::message(__('lang.deleted_success', ['attribute' => __('lang.product_option')]));

        return redirect()->back();
    }
}
