<?php

namespace Sebastienheyd\Boilerplate\Models;

use Laratrust\Models\Permission as LaratrustPermission;

class Permission extends LaratrustPermission
{
    public function category()
    {
        return $this->belongsTo(PermissionCategory::class);
    }

    public function getDisplayNameAttribute($value)
    {
        return __($value);
    }

    public function getDescriptionAttribute($value)
    {
        return __($value);
    }
}
