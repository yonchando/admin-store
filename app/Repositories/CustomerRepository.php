<?php

namespace App\Repositories;

use App\Models\Customer;
use App\Repositories\Contracts\CustomerRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class CustomerRepository implements CustomerRepositoryInterface
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
            'purchaseOrders' => fn($query) => $query->withCount(['orderItems']),
        ]);

        $query->withCount(['purchaseOrders']);

        return $query->find($id);
    }
}