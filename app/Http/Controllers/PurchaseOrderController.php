<?php

namespace App\Http\Controllers;

use App\Enums\PurchaseOrder\PurchaseOrderStatus;
use App\Facades\Helper;
use App\Models\PurchaseOrder;
use App\Repositories\Contracts\PurchaseOrderInterface;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Inertia\Inertia;

class PurchaseOrderController extends Controller
{


    public function __construct(
        private readonly PurchaseOrderInterface $purchaseOrder,
    ) {
    }

    public function index(Request $request)
    {
        $purchaseOrders = $this->purchaseOrder->paginate($request);

        return Inertia::render('PurchaseOrder/Index', [
            'purchaseOrders' => $purchaseOrders,
            'status' => PurchaseOrderStatus::toJson(),
        ]);
    }

    public function show(PurchaseOrder $purchaseOrder)
    {
        $purchase = $this->purchaseOrder->find($purchaseOrder->id);

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

        $this->purchaseOrder->updateStatus($request, $purchaseOrder->id);

        Helper::message(__('lang.updated_success', ['attribute' => __('lang.purchase_status')]));
        return redirect()->back();
    }
}
