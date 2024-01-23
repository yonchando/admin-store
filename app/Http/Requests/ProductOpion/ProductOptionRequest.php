<?php

namespace App\Http\Requests\ProductOpion;

use Illuminate\Foundation\Http\FormRequest;

class ProductOptionRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required'],
            'price_adjustment' => ['nullable', 'numeric'],
        ];
    }

    public function authorize(): bool
    {
        return auth()->check();
    }
}
