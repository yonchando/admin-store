<?php

namespace App\Http\Requests;

use App\Enums\Order\PurchaseStatusEnum;
use App\Models\Purchase;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class PurchaseStatusRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'status' => ['required', Rule::in(PurchaseStatusEnum::toJson())],
            'reason' => [
                Rule::requiredIf(function () {
                    return in_array($this->string('status'),
                        [PurchaseStatusEnum::REJECTED->value, PurchaseStatusEnum::CANCEL->value]);
                }),
            ],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }

    public function validateStatus(Purchase $purchase): array
    {
        $validationStatus = [
            PurchaseStatusEnum::PENDING->value => [
                PurchaseStatusEnum::ACCEPTED->value,
                PurchaseStatusEnum::REJECTED->value,
                PurchaseStatusEnum::CANCEL->value,
            ],
            PurchaseStatusEnum::ACCEPTED->value => [
                PurchaseStatusEnum::COMPLETED->value,
                PurchaseStatusEnum::CANCEL->value,
            ],
        ];

        $isInvalidStatus = in_array($this->string('status'), $validationStatus[$purchase->status->value]);

        if (! ___($validationStatus, $purchase->status->value) || ! $isInvalidStatus) {
            throw ValidationException::withMessages([
                'status' => 'Invalid status',
            ]);
        }

        return $this->safe()->only(['status', 'reason']);
    }
}
