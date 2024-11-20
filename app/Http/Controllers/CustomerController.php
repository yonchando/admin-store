<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomerRequest;
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

        return Inertia::render('Customer/CustomerIndex', [
            'customers' => $customers,
        ]);
    }

    public function create()
    {
        return Inertia::render('Customer/CustomerForm');
    }

    public function store(CustomerRequest $request)
    {
        $this->customerService->store($request);

        return to_route('customer.index')->with('success', __('lang.created_success', ['attribute' => __('lang.customer')]));
    }

    public function show($id)
    {
        $customer = $this->customerService->find($id);

        return Inertia::render('Customer/CustomerShow', [
            'customer' => $customer,
        ]);
    }

    public function edit($id)
    {
        $customer = $this->customerService->find($id);

        return Inertia::render('Customer/CustomerForm', [
            'customer' => $customer,
        ]);
    }

    public function update(CustomerRequest $request, $id)
    {
        $customer = $this->customerService->find($id);

        $this->customerService->update($request, $customer);

        return to_route('customer.index')->with('success', __('lang.updated_success', ['attribute' => __('lang.customer')]));
    }
}
