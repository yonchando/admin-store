<?php

namespace App\Repositories;

use App\Models\PurchaseOrder;
use App\Repositories\Contracts\PurchaseOrderInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class PurchaseOrderRepository implements PurchaseOrderInterface
{

    public function all(): Collection
    {
        return PurchaseOrder::all();
    }

    public function paginate(Request $request): LengthAwarePaginator
    {
        $query = PurchaseOrder::query();

        return $query->paginate();
    }

    public function updateStatus(Request $request, int $id): bool
    {
        $order = PurchaseOrder::find($id);
        $order->status = $request->get('status');
        return $order->save();
    }
}