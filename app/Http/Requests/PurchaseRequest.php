<?php

namespace App\Http\Requests;

use App\Enums\Order\PurchaseStatusEnum;
use App\Models\Customer;
use App\Models\Product;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PurchaseRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'customer_id' => ['required', Rule::exists(Customer::class, 'id')],
            'products.*.qty' => ['required', 'integer', 'min:1'],
            'products.*.product_id' => ['required', Rule::exists(Product::class, 'id')],
            'status' => ['required', Rule::enum(PurchaseStatusEnum::class)],
            'purchase_date' => ['required', 'date:Y-m-d H:i:s'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
