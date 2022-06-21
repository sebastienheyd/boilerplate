<?php

if (! function_exists('dot_str')) {
    function dot_str($string)
    {
        return str_replace(['[', ']'], ['.', ''], $string);
    }
}

if (! function_exists('bool')) {
    function bool($val)
    {
        $boolval = (is_string($val) ? filter_var($val, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE) : (bool) $val);

        return $boolval === null ? false : $boolval;
    }
}

if (! function_exists('setting')) {
    function setting($name, $default = null)
    {
        $user = \Illuminate\Support\Facades\Auth::user();

        if ($user) {
            return $user->setting($name, $default);
        }

        return $default;
    }
}

if (! function_exists('channel_hash')) {
    function channel_hash(...$values): string
    {
        $signature = md5(join('|', $values).config('app.key').config('app.url'));

        return join('.', array_merge($values, [$signature]));
    }
}

if (! function_exists('channel_hash_equals')) {
    function channel_hash_equals($signature, ...$values): string
    {
        return $signature === md5(join('|', $values).config('app.key').config('app.url'));
    }
}
