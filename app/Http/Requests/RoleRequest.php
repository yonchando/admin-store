<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RoleRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'code' => ['required'],
            'name' => ['required'],
            'status' => ['required'],
            'permissions' => ['nullable', 'array'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
