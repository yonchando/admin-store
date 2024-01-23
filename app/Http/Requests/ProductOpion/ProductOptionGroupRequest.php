<?php

namespace App\Http\Requests\ProductOpion;

use Illuminate\Foundation\Http\FormRequest;

class ProductOptionGroupRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required'],
        ];
    }

    public function authorize(): bool
    {
        return auth()->check();
    }
}
