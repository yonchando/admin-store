<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ModuleRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'code' => ['required'],
            'name' => ['required'],
            'status' => ['required'],
            'permissions' => ['required'],
        ];
    }

    public function authorize(): bool
    {
        return auth()->check();
    }
}
