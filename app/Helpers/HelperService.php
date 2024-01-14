<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Session;

class HelperService
{
    public function message($message, $type = 'success', $key = 'message'): void
    {
        Session::flash($key, [
            'text' => $message,
            'type' => $type,
        ]);
    }

    public function enumToArray(array $enum, $getValue = false): array
    {
        return collect($enum)->map(fn($value) => $getValue ? $value->value : $value->name)->toArray();
    }

    public function enumToSelectForm(array $enum, $getValue = false): array
    {
        return collect($enum)->map(fn($value) => [
            'id' => $getValue ? $value->value : $value->name,
            'text' => $getValue ? $value->value : $value->name,
        ])->toArray();
    }

}