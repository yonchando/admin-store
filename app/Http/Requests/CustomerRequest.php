<?php

namespace App\Http\Requests;

use App\Enums\Customer\CustomerStatusEnum;
use App\Models\Customer;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CustomerRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'nickname' => ['nullable', 'string', 'max:100'],
            'phone_number' => ['required', Rule::unique(Customer::class, 'phone_number')->ignore($this->get('id'))],
            'email' => [
                'nullable',
                'email',
                'max:100',
                Rule::unique(Customer::class, 'email')->ignore($this->get('id')),
            ],
            'password' => [
                'required',
                'min:6',
            ],
            'password_confirmation' => ['same:password'],
            'socialize_token' => ['nullable'],
            'gender' => ['nullable', Rule::in(['male', 'female'])],
            'image' => ['nullable', Rule::imageFile()->max('10mb')],
            'status' => ['required', Rule::in(array_values(CustomerStatusEnum::toJson()))],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
