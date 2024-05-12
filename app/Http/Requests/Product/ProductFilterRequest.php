<?php

namespace App\Http\Requests\Product;

use App\Enums\Product\ProductStatus;
use App\Facades\Enum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductFilterRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'category_id' => ['nullable', Rule::exists('categories', 'id'), 'int'],
            'search' => ['nullable', 'string', 'max:255'],
            'min_price' => ['nullable', 'numeric'],
            'max_price' => ['nullable', 'numeric'],
            'status' => ['nullable', Rule::in(array_values(array_values(ProductStatus::toJson())))],
            'perPage' => ['nullable', 'numeric'],
        ];
    }

    public function authorize(): bool
    {
        return auth()->check();
    }
}
