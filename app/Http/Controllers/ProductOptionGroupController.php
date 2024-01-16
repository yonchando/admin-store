<?php

namespace App\Http\Controllers;

use App\Facades\Helper;
use App\Http\Requests\ProductOptionGroupRequest;
use App\Models\ProductOptionGroup;
use App\Repositories\Contracts\ProductOptionGroupRepositoryInterface;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProductOptionGroupController extends Controller
{

    public function __construct(
        private readonly ProductOptionGroupRepositoryInterface $productOptionGroupRepository,
    ) {
    }

    public function index(Request $request)
    {
        $groups = $this->productOptionGroupRepository->get($request);
        return Inertia::render('ProductOption/Index', [
            'groups' => $groups,
        ]);
    }

    public function store(ProductOptionGroupRequest $request)
    {
        $this->productOptionGroupRepository->store($request);

        Helper::message(__('lang.created_success', ['attribute' => __('lang.product_option_group')]));

        return redirect()->back();
    }

    public function update(ProductOptionGroupRequest $request, ProductOptionGroup $productOptionGroup)
    {
        $this->productOptionGroupRepository->update($request, $productOptionGroup);

        Helper::message(__('lang.updated_success', ['attribute' => __('lang.product_option_group')]));

        return redirect()->back();
    }

    public function destroy(ProductOptionGroup $productOptionGroup)
    {
        $this->productOptionGroupRepository->destroy($productOptionGroup->id);

        Helper::message(__('lang.deleted_success', ['attribute' => __('lang.product_option_group')]));

        return back();
    }
}
