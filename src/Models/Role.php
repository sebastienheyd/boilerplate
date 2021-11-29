<?php

namespace Sebastienheyd\Boilerplate\Models;

use Laratrust\Models\LaratrustRole;

class Role extends LaratrustRole
{
    protected $fillable = ['name', 'display_name', 'description'];

    public function getDisplayNameAttribute($value)
    {
        return __($value);
    }

    public function getDescriptionAttribute($value)
    {
        return __($value);
    }
}
