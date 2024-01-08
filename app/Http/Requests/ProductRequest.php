<?php

namespace App\Http\Requests;

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
        ];
    }

    public function authorize(): bool
    {
        return auth()->check();
    }
}
