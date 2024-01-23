<?php

namespace App\Http\Requests\ProductOpion;

use Illuminate\Foundation\Http\FormRequest;

class ProductOptionStoreManyRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'options.*.name' => ['required'],
            'options.*.price_adjustment' => ['nullable', 'numeric'],
        ];
    }

    public function attributes(): array
    {
        return [
            'options.*.name' => __('lang.name'),
            'options.*.price_adjustment' => __('lang.price_adjustment'),
        ];
    }

    public function authorize(): bool
    {
        return auth()->check();
    }
}
