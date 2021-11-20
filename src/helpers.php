<?php

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
