<?php

namespace App\Http\Requests\Setting;

use App\Enums\Setting\SettingKeyEnum;
use Closure;
use Illuminate\Foundation\Http\FormRequest;

class SettingRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            '*' => [
                function (string $attribute, mixed $value, Closure $fail) {
                    if (SettingKeyEnum::tryFrom($attribute) == null) {
                        $fail("Attribute {$attribute} is invalid");
                    }
                },
            ],
        ];
    }

    public function authorize(): bool
    {
        return auth()->check();
    }
}
