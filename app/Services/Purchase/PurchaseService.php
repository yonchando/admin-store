<?php

namespace App\Services\Purchase;

use App\Casts\Purchase\PurchaseJson;
use App\Enums\Order\PurchaseStatusEnum;
use App\Http\Requests\Purchase\PurchaseRequest;
use App\Http\Requests\PurchaseStatusRequest;
use App\Models\Purchase;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Str;

class PurchaseService
{
    public function __construct(
        private readonly PurchaseDetailService $purchaseDetailService,
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

        $details = $this->purchaseDetailService->createOrEdit($request);

        $purchase = new Purchase;

        $purchase->fill([
            'customer_id' => $request->get('customer_id'),
            'status' => $request->get('status'),
            'ref_no' => Str::random(),
            'total' => Collect($details)->sum('sub_total'),
            'purchased_at' => $request->get('purchase_date'),
        ]);

        $purchase->save();

        $purchase->purchaseDetails()->saveMany($details);

        \DB::commit();

        return $purchase;
    }

    public function findById($id): Purchase
    {
        return Purchase::with(['customer', 'purchaseDetails'])
            ->withCount(['purchaseDetails'])
            ->findOrFail($id);
    }

    public function updateStatus(PurchaseStatusRequest $request, Purchase $purchase): Purchase
    {
        $data = $request->validateStatus($purchase);

        $status = PurchaseStatusEnum::tryFrom(___($data, 'status'));

        $json = new PurchaseJson;
        $json->reason = ___($data, 'reason');

        $purchase->status = $status;
        $purchase->json = $json;
        $purchase->save();

        return $purchase;
    }

    public function update(PurchaseRequest $request, Purchase $purchase): Purchase
    {
        \DB::beginTransaction();

        $details = $this->purchaseDetailService->createOrEdit($request);

        $purchase->fill([
            'customer_id' => $request->get('customer_id'),
            'status' => $request->get('status'),
            'total' => collect($details)->sum('sub_total'),
            'purchased_at' => $request->get('purchase_date'),
        ]);

        $purchase->save();

        $purchase->purchaseDetails()->saveMany($details);

        \DB::commit();

        return $purchase;
    }
}
