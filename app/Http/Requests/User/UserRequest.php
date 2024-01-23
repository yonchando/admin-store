<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required'],
            'username' => ['required'],
            'password' => [
                Rule::requiredIf($this->user == null),
                Rule::when($this->user == null, [
                    'confirmed',
                    'min: 6',
                    'string:255',
                ]),
            ],
            'password_confirmation' => [Rule::requiredIf($this->user == null)],
            'gender' => ['nullable'],
        ];
    }

    public function authorize(): bool
    {
        return auth()->check();
    }
}
