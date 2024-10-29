<?php

namespace App\Http\Controllers;

use App\Enums\Product\ProductStatus;
use App\Facades\Helper;
use App\Http\Requests\Product\ProductRequest;
use App\Models\Product;
use App\Repositories\Contracts\CategoryRepositoryInterface;
use App\Repositories\Contracts\ProductOptionGroupRepositoryInterface;
use App\Repositories\Contracts\ProductOptionRepositoryInterface;
use App\Repositories\Contracts\ProductRepositoryInterface;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProductController extends Controller
{
    public function __construct(
        private readonly ProductRepositoryInterface $productRepository,
        private readonly CategoryRepositoryInterface $categoryRepository,
        private readonly ProductOptionGroupRepositoryInterface $productOptionGroupRepository,
        private readonly ProductOptionRepositoryInterface $productOptionRepository,
    ) {}

    public function index(Request $request)
    {
        $categories = $this->categoryRepository->get();

        $request->merge([
            'includes' => ['category' => function ($query) {
                $query->select(['id', 'category_name as name']);
            }],
        ]);

        $products = $this->productRepository->paginate();

        $statuses = ProductStatus::toArray();

        return Inertia::render('Product/ProductIndex', [
            'products' => $products,
            'statuses' => fn () => $statuses,
            'categories' => Inertia::lazy(fn () => $categories),
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
        $this->productRepository->store($request);

        return redirect()->route('product.index')
            ->with('success', __('lang.created_success', ['attribute' => __('lang.product')]));
    }

    public function show(Request $request, $id)
    {
        $product = $this->productRepository->find($id);
        $groups = $this->productOptionGroupRepository->get($request);
        $options = $this->productOptionRepository->get($request);

        return Inertia::render('Product/Show', [
            'product' => $product,
            'groups' => $groups,
            'options' => $options,
        ]);
    }

    public function edit($id)
    {
        $categories = $this->categoryRepository->get();
        $product = $this->productRepository->find($id);
        $statuses = ProductStatus::toArray();

        return Inertia::render('Product/ProductForm', [
            'categories' => $categories,
            'product' => $product,
            'statuses' => $statuses,
        ]);
    }

    public function update(ProductRequest $request, $id)
    {
        $product = Product::find($id);
        $this->productRepository->update($request, $product);

        return redirect()->route('product.index')
            ->with('success', __('lang.updated_success', ['attribute' => __('lang.product')]));
    }

    public function updateStatus($id)
    {
        $product = $this->productRepository->updateStatus(Product::find($id));

        Helper::message(__('lang.updated_success', ['attribute' => __('lang.status')]));

        return to_route('product.index');
    }

    public function destroy(Request $request)
    {
        $ids = $request->get('ids', []);

        $this->productRepository->destroy($ids);

        return redirect()->route('product.index', request()->toArray());
    }
}
