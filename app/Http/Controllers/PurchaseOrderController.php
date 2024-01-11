<?php

namespace App\Http\Controllers;

use App\Repositories\Contracts\PurchaseOrderInterface;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PurchaseOrderController extends Controller
{


    public function __construct(
        private readonly PurchaseOrderInterface $purchaseOrder,
    ) {
    }

    public function index(Request $request)
    {
        $pruchaseOrders = $this->purchaseOrder->paginate($request);
        return Inertia::render('PurchaseOrder/Index', [
            'purchaseOrders' => $pruchaseOrders,
        ]);
    }
}
