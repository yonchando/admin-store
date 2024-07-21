<?php

namespace App\Http\Controllers\Purchase;

use App\Enums\PurchaseOrder\PurchaseOrderStatus;
use App\Facades\Helper;
use App\Http\Controllers\Controller;
use App\Models\PurchaseOrder;
use App\Repositories\Contracts\PurchaseOrderRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Inertia\Inertia;

class PurchaseOrderController extends Controller
{
    public function __construct(
        private readonly PurchaseOrderRepositoryInterface $purchaseOrderRepository,
    ) {
    }

    public function index(Request $request)
    {
        $purchaseOrders = $this->purchaseOrderRepository->paginate($request);

        return Inertia::render('PurchaseOrder/Index', [
            'purchaseOrders' => $purchaseOrders,
            'status' => PurchaseOrderStatus::toJson(),
        ]);
    }

    public function show(PurchaseOrder $purchaseOrder)
    {
        $purchase = $this->purchaseOrderRepository->find($purchaseOrder->id);

        return Inertia::render('PurchaseOrder/Show', [
            'purchase' => $purchase,
            'status' => PurchaseOrderStatus::toJson(),
        ]);
    }

    public function updateStatus(Request $request, PurchaseOrder $purchaseOrder)
    {
        $this->validate($request, [
            'status' => [Rule::in(PurchaseOrderStatus::cases())],
        ]);

        $this->purchaseOrderRepository->updateStatus($request, $purchaseOrder->id);

        Helper::message(__('lang.updated_success', ['attribute' => __('lang.purchase_status')]));
        return redirect()->back();
    }
}
