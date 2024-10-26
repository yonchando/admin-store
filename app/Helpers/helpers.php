<?php

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
