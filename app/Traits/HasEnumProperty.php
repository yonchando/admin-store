<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait HasEnumProperty
{
    public static function toArray(array $excepts = []): array
    {
        return collect(self::cases())
            ->map(
                fn($value) => [
                    'text' => __('lang.'.Str::lower($value->value)),
                    'id' => $value->value,
                ]
            )->filter(fn($value) => !in_array($value['id'], $excepts))
            ->toArray();
    }

    public static function toJson(): array
    {
        return collect(self::cases())
            ->flatMap(
                fn($value) => [
                    $value->name => $value->value,
                ]
            )->toArray();
    }

    public function getValue()
    {
        if(method_exists($this,'severities')){
            $severities = $this->severities();
            
            if(!data_get($severities,$this->value)){
                return null;
            }
            
            return [
                'text' => __('lang.'.Str::lower($this->value)),
                'id' => $this->value,
                'severity' => $severities[$this->value],
            ];
        }
        
        return $this->value;
    }
}
