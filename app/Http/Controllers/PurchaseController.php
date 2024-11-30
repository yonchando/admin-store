<?php

namespace App\Http\Controllers;

use App\Enums\Order\PurchaseStatusEnum;
use App\Http\Requests\Purchase\PurchaseRequest;
use App\Http\Requests\PurchaseStatusRequest;
use App\Services\CustomerService;
use App\Services\ProductService;
use App\Services\Purchase\PurchaseService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PurchaseController extends Controller
{
    public function __construct(
        private readonly PurchaseService $purchaseService,
        private readonly ProductService $productService,
        private readonly CustomerService $customerService,
    ) {}

    public function index(Request $request)
    {
        return Inertia::render('Purchase/PurchaseIndex', [
            'purchases' => $this->purchaseService->paginate($request),
            'requests' => $request->all(),
        ]);
    }

    public function create()
    {
        return Inertia::render('Purchase/PurchaseForm', [
            'statuses' => PurchaseStatusEnum::toArray(),
            'products' => Inertia::lazy(fn () => $this->productService->paginate()),
            'customers' => Inertia::lazy(fn () => $this->customerService->paginate(['pageName' => 'customer-page'])),
        ]);
    }

    public function store(PurchaseRequest $request)
    {
        $this->purchaseService->store($request);

        return to_route('purchase.index')->with('success',
            __('lang.created_success', ['attribute' => __('lang.purchase')]));
    }

    public function show($id)
    {
        $purchase = $this->purchaseService->findById($id);

        return Inertia::render('Purchase/PurchaseShow', [
            'purchase' => $purchase,
            'statuses' => PurchaseStatusEnum::toJson(),
        ]);
    }

    public function edit($id)
    {
        return Inertia::render('Purchase/PurchaseForm', [
            'purchase' => $this->purchaseService->findById($id),
            'statuses' => PurchaseStatusEnum::toArray(),
            'products' => Inertia::lazy(fn () => $this->productService->paginate()),
            'customers' => Inertia::lazy(fn () => $this->customerService->paginate(['pageName' => 'customer-page'])),
        ]);
    }

    public function update(PurchaseRequest $request, $id)
    {
        $this->purchaseService->update($request, $this->purchaseService->findById($id));

        return to_route('purchase.index')
            ->with('success', __('lang.updated_success', ['attribute' => __('lang.purchase')]));
    }

    public function updateStatus(PurchaseStatusRequest $request, $id)
    {
        $purchase = $this->purchaseService->findById($id);

        $this->purchaseService->updateStatus($request, $purchase);

        return back()->with('success', "Purchase {$request->string('status')} successfully!.");
    }

    public function destroy($id) {}
}
