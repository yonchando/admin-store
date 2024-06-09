<?php

namespace App\Casts\Setting;

use Yonchando\CastAttributes\CastAttributes;

class PropertyCast extends CastAttributes
{
    private ?int $currencyId = null;

    public function getCurrencyId(): ?int
    {
        return $this->currencyId;
    }

    public function setCurrencyId(?int $currencyId): void
    {
        $this->currencyId = $currencyId;
    }
}
