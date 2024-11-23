<?php

use Carbon\Carbon;

if (! function_exists('___')) {
    function ___($target, $key, $default = null)
    {
        return data_get($target, $key, $default);
    }
}

if (! function_exists('flash')) {
    function flash(string $type, string|array $message): void
    {
        session()->flash($type, $message);
    }
}

if (! function_exists('_date')) {
    function _date(string|Date|null $key): ?string
    {
        if (! $key) {
            return null;
        }

        return Carbon::parse($key)->format('Y-m-d | h:i A');
    }
}

if (! function_exists('log_info')) {
    function log_info(string $message, array $context = [], array $stacktrace = []): void
    {
        $messages = "$message\n";

        if (! empty($context)) {
            $messages .= json_encode($context, JSON_PRETTY_PRINT);
        }

        if (! empty($stacktrace)) {
            $messages .= "\n[stacktrace]\n".json_encode($stacktrace, JSON_PRETTY_PRINT);
        }

        Log::channel('daily_info')->info($messages);
    }
}
