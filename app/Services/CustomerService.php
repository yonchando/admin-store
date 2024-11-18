<?php

namespace App\Services;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class CustomerService
{
    public function paginate(Request $request): LengthAwarePaginator
    {
        $query = Customer::query();

        $query->withCount(['purchaseOrders']);

        return $query->paginate($request->get('perPage', 25));
    }

    public function find(int $id): Customer
    {
        $query = Customer::query();

        $query->with([
            'purchaseOrders' => fn ($query) => $query->withCount(['purchaseDetails']),
        ]);

        $query->withCount(['purchaseOrders']);

        return $query->find($id);
    }
}
