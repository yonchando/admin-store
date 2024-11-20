<?php

namespace App\Services;

use App\Facades\Helper;
use App\Http\Requests\CustomerRequest;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Storage;

class CustomerService
{
    public function paginate(Request $request): LengthAwarePaginator
    {
        $query = Customer::query();

        return $query->paginate($request->get('perPage', 20));
    }

    public function find(int $id): Customer
    {
        return Customer::query()->find($id);
    }

    public function store(CustomerRequest $request): Customer
    {
        $customer = new Customer($request->safe()->except('image'));

        if ($request->hasFile('image')) {
            $this->uploadImage($customer, $request->file('image'));
        }

        $customer->save();

        return $customer;
    }

    public function update(CustomerRequest $request, Customer $customer): Customer
    {
        $customer->fill($request->safe()->except('image', 'password', 'password_confirmation'));

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $this->uploadImage($customer, $file);
        }

        if ($request->get('password')) {
            $customer->password = $request->get('password');
        }

        $customer->save();

        return $customer;
    }

    private function uploadImage(Customer $customer, UploadedFile $file): void
    {
        Storage::putFileAs($customer->image->path, $file, $file->hashName());
        $customer->image = Helper::imageInit($file, config('paths.customer_profile'));
    }
}
