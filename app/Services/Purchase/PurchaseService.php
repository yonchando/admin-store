<?php

namespace App\Services\Purchase;

use App\Http\Requests\PurchaseRequest;
use App\Models\Purchase;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Str;

class PurchaseService
{
    public function __construct(
        private PurchaseDetailService $purchaseDetailService,
    ) {}

    /**
     * @return LengthAwarePaginator<Purchase>
     */
    public function paginate(Request $request): LengthAwarePaginator
    {
        $query = Purchase::query();

        $query->latest();

        $query->filters($request->all());

        $query->with(['customer']);
        $query->withCount(['purchaseDetails']);

        return $query->paginate($request->get('perPage', 20));
    }

    public function store(PurchaseRequest $request): Purchase
    {
        \DB::beginTransaction();

        $details = $this->purchaseDetailService->create($request);

        $purchase = new Purchase;

        $purchase->fill([
            'customer_id' => $request->get('customer_id'),
            'status' => $request->get('status'),
            'ref_no' => Str::random(),
            'total' => $details->sum('sub_total'),
            'purchased_at' => $request->get('purchase_date'),
        ]);

        $purchase->save();

        $purchase->purchaseDetails()->saveMany($details);

        \DB::commit();

        return $purchase;
    }
}
