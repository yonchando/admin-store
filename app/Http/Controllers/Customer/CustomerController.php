<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Repositories\Contracts\CustomerRepositoryInterface;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CustomerController extends Controller
{


    public function __construct(
        private readonly CustomerRepositoryInterface $customerRepository,
    ) {
    }

    public function index(Request $request)
    {
        $customers = $this->customerRepository->paginate($request);

        return Inertia::render('Customer/Index', [
            'customers' => $customers,
        ]);
    }

    public function show(Customer $customer)
    {
        $customer = $this->customerRepository->find($customer->id);
        return Inertia::render('Customer/Show', [
            'customer' => $customer,
        ]);
    }
}
