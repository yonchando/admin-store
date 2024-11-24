<?php

namespace App\Services;

use App\Facades\Helper;
use App\Http\Requests\CustomerRequest;
use App\Models\Customer;
use Illuminate\Http\UploadedFile;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Storage;

class CustomerService
{
    public function paginate(array $filters = []): LengthAwarePaginator
    {
        $query = Customer::query();

        $query->filters($filters);

        $query->latest();

        return $query->paginate(___($filters, 'perPage', 20), ['*'], ___($filters, 'pageName', 'page'));
    }

    public function find(int $id): Customer
    {
        return Customer::query()->find($id);
    }

    public function store(CustomerRequest $request): Customer
    {
        $customer = new Customer($request->safe()->except('profile'));

        if ($request->hasFile('profile')) {
            $this->uploadImage($customer, $request->file('profile'));
        }

        $customer->save();

        return $customer;
    }

    public function update(CustomerRequest $request, Customer $customer): Customer
    {
        $customer->fill($request->safe()->except('profile', 'password', 'password_confirmation'));

        if ($request->hasFile('profile')) {
            $this->uploadImage($customer, $request->file('profile'));
        }

        if ($request->get('password')) {
            $customer->password = $request->get('password');
        }

        $customer->save();

        return $customer;
    }

    private function uploadImage(Customer $customer, UploadedFile $file): void
    {
        $path = config('paths.customer_profile');
        Storage::putFileAs($path, $file, $file->hashName());
        $customer->profile = Helper::imageInit($file, $path);
    }

    public function destroy(mixed $ids): int
    {
        return Customer::destroy($ids);
    }
}
