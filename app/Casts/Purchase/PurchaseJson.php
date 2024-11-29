<?php

namespace App\Casts\Purchase;

use Yonchando\CastAttributes\CastAttributes;

class PurchaseJson extends CastAttributes
{
    public ?string $reason = '';
}
