<?php

namespace App\Http\Requests\Setting;

use Illuminate\Foundation\Http\FormRequest;

class SettingRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'currency_id' => ['required'],
        ];
    }

    public function authorize(): bool
    {
        return auth()->check();
    }
}
