<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CardRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required'],
            'number' => ['required'],
            'expired_at' => ['nullable'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
