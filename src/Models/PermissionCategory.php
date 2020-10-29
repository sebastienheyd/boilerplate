<?php

namespace Sebastienheyd\Boilerplate\Models;

// phpcs:disable Generic.Files.LineLength

use Illuminate\Database\Eloquent\Model;

class PermissionCategory extends Model
{
    protected $fillable = ['name', 'display_name'];
    protected $table = 'permissions_categories';
    protected $dates = [];

    public function getDisplayNameAttribute($value)
    {
        return __($value);
    }
}
