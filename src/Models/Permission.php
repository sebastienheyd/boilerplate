<?php

namespace Sebastienheyd\Boilerplate\Models;

use Laratrust\LaratrustPermission;

class Permission extends LaratrustPermission
{
    public function getDisplayNameAttribute($value)
    {
        return __($value);
    }

    public function getDescriptionAttribute($value)
    {
        return __($value);
    }
}