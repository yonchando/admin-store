<?php

namespace App\Http\Controllers;

use App\Enums\Customer\CustomerStatusEnum;
use App\Enums\GenderEnum;
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
        $customers = $this->customerService->paginate($request->all());

        if ($request->wantsJson()) {
            return response()->json($customers);
        }

        return Inertia::render('Customer/CustomerIndex', [
            'customers' => $customers,
            'requests' => $request->all(),
        ]);
    }

    public function create()
    {
        return Inertia::render('Customer/CustomerForm', [
            'statuses' => CustomerStatusEnum::toArray(),
            'gender' => GenderEnum::toArray(),
        ]);
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
            'statuses' => CustomerStatusEnum::toArray(),
            'gender' => GenderEnum::toArray(),
        ]);
    }

    public function update(CustomerRequest $request, $id)
    {
        $customer = $this->customerService->find($id);

        $this->customerService->update($request, $customer);

        return to_route('customer.index')->with('success', __('lang.updated_success', ['attribute' => __('lang.customer')]));
    }

    public function destroy(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
        ]);

        $ids = $request->get('ids', []);

        $this->customerService->destroy($ids);

        return to_route('customer.index')->with('success', __('lang.deleted_success', ['attribute' => __('lang.customer')]));
    }
}
