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

if (! function_exists('pusher')) {
    function pusher($event = null, $data = [])
    {
        $config = config('broadcasting.connections.pusher');
        foreach (['key', 'secret', 'app_id'] as $k) {
            if(empty($config[$k])) {
                return false;
            }
        }

        try {
            $pusher = new \Pusher\Pusher(
                config('broadcasting.connections.pusher.key'),
                config('broadcasting.connections.pusher.secret'),
                config('broadcasting.connections.pusher.app_id'),
                ['cluster' => config('broadcasting.connections.pusher.options.cluster', 'eu'), 'encrypted' => true]
            );
        } catch (\Exception $e) {
            return false;
        }

        if ($event === null) {
            return $pusher;
        }

        return $pusher->trigger(md5(config('app.name').config('app.env')), $event, $data);
    }
}
