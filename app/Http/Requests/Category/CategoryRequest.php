<?php

namespace App\Http\Requests\Category;

use App\Models\Category;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CategoryRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'category_name' => [
                'required',
                Rule::unique(Category::class, 'category_name')->ignore($this->id),
            ],
            'parent_id' => ['nullable', Rule::exists('categories', 'id')],
        ];
    }

    public function authorize(): bool
    {
        return auth()->check();
    }
}
