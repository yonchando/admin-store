<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required'],
            'username' => ['required'],
            'password' => ['required', 'confirmed', 'min: 6', 'string:255'],
            'password_confirmation' => ['required'],
            'gender' => ['nullable'],
        ];
    }

    public function authorize(): bool
    {
        return auth()->check();
    }
}
