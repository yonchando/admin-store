<?php

namespace App\Http\Requests\Category;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CategoryRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'category_name' => ['required', Rule::unique('categories', 'category_name')],
        ];
    }

    public function authorize(): bool
    {
        return auth()->check();
    }
}
