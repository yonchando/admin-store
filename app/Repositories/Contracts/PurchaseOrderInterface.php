<?php

namespace App\Repositories\Contracts;

use App\Models\PurchaseOrder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

interface PurchaseOrderInterface
{
    /**
     * @return Collection<PurchaseOrder>
     */
    public function all(): Collection;

    /**
     * @return LengthAwarePaginator<PurchaseOrder>
     */
    public function paginate(Request $request): LengthAwarePaginator;

    public function updateStatus(Request $request, int $id): bool;
}