<?php

namespace App\Models;

use App\Casts\Purchase\PurchaseJson;
use App\Enums\Order\PurchaseStatusEnum;
use App\Models\Concerns\Purchase\HasAttributes;
use App\Models\Concerns\Purchase\HasRelationships;
use App\Models\Concerns\Purchase\HasScopes;
use App\Traits\HasTimestamps;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property PurchaseJson $json
 */
class Purchase extends Model
{
    use HasAttributes;
    use HasFactory;
    use HasRelationships;
    use HasScopes;
    use HasTimestamps;

    protected $fillable = [
        'ref_no',
        'customer_id',
        'total',
        'status',
        'purchased_at',
    ];

    protected $casts = [
        'status' => PurchaseStatusEnum::class,
        'purchased_at' => 'datetime:Y-m-d | h:i A',
        'json' => PurchaseJson::class,
    ];

    protected $appends = [];
}
