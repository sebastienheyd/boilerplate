<?php

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
