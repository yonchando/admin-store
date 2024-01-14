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
            'password' => ['required'],
            'gender' => ['nullable'],
            'status' => ['required'],
            'remember_token' => ['nullable'],
        ];
    }

    public function authorize(): bool
    {
        return auth()->check();
    }
}
