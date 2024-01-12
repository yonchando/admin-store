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

        $query->with(['customer']);

        $query->withCount(['orderItems']);

        if ($request->has('orderBy')) {
            $query->orderBy($request->get('orderBy'), $request->get('direction', 'asc'));
        } else {
            $query->orderByDesc('purchased_at');
        }

        return $query->paginate($request->get('perPage', 15));
    }

    public function find(int $id): PurchaseOrder
    {
        $query = PurchaseOrder::query();

        $query->with(['customer', 'orderItems']);

        return $query->find($id);
    }

    public function updateStatus(Request $request, int $id): PurchaseOrder
    {
        $purchase = PurchaseOrder::find($id);

        $purchase->status = $request->get('status');

        $purchase->save();

        return $purchase;
    }

}