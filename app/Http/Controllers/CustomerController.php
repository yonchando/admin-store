<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Services\CustomerService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CustomerController extends Controller
{
    public function __construct(
        private readonly CustomerService $customerService,
    ) {}

    public function index(Request $request)
    {
        $customers = $this->customerService->paginate($request);

        return Inertia::render('Customer/Index', [
            'customers' => $customers,
        ]);
    }

    public function show(Customer $customer)
    {
        $customer = $this->customerService->find($customer->id);

        return Inertia::render('Customer/Show', [
            'customer' => $customer,
        ]);
    }
}
