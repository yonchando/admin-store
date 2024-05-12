<?php

namespace App\ValueObjects\Setting;

use App\ValueObjects\JsonProperty;

class SettingPropertyObject extends JsonProperty
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
