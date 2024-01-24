<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'product_name' => ['required'],
            'description' => ['required'],
            'price' => ['nullable', 'numeric'],
            'stock_quantity' => ['nullable', 'integer'],
            'category_id' => ['nullable', 'integer'],
            'image' => ['nullable'],
            'slug' => ['nullable'],
            'product_options' => ['nullable', 'array'],
        ];
    }

    public function authorize(): bool
    {
        return auth()->check();
    }
}
