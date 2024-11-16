<?php

namespace App\Http\Requests\User;

use App\Enums\Staff\StaffStatusEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\File;

class StaffRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required'],
            'username' => ['required'],
            'password' => [
                Rule::requiredIf($this->id == null),
                Rule::when($this->id == null, [
                    'min: 6',
                    'string:255',
                ]),
            ],
            'password_confirmation' => [Rule::requiredIf($this->id == null), 'same:password'],
            'position' => ['nullable', 'string'],
            'gender' => ['nullable'],
            'profile' => ['nullable', File::image()->extensions(['jpg', 'png', 'jpeg', 'gif'])->size('2mb')],
            'status' => ['nullable', Rule::in(array_values(StaffStatusEnum::toJson()))],
            'role_ids' => ['nullable', 'array'],
            'permission_ids' => ['nullable', 'array'],
        ];
    }

    public function authorize(): bool
    {
        return auth()->check();
    }
}
