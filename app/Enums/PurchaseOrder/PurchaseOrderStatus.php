<?php

namespace App\Enums\PurchaseOrder;

use Illuminate\Support\Str;

enum PurchaseOrderStatus: string
{
    case PENDING = 'pending';
    case ACCEPTED = 'accepted';
    case SHIPPED = 'shipped';
    case CANCELED = 'canceled';
    case REJECTED = 'rejected';
    case COMPLETED = 'completed';

    public static function toArray(array $excepts = []): array
    {
        return collect(self::cases())
            ->map(
                fn($value) => [
                    'name' => __('lang.' . Str::lower($value->name)),
                    'id' => $value->name,
                ]
            )->filter(fn($value) => !in_array($value['id'], $excepts))
            ->toArray();
    }

    public static function toJson(): array
    {
        return collect(self::cases())
            ->flatMap(
                fn($value) => [
                    $value->name => $value->name,
                ]
            )->toArray();
    }
}
