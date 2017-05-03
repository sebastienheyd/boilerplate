<?php

namespace Sebastienheyd\Boilerplate\Models;

use Laratrust\LaratrustPermission;

/**
 * Sebastienheyd\Boilerplate\Models\Permission
 *
 * @property int $id
 * @property string $name
 * @property string $display_name
 * @property string $description
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\Sebastienheyd\Boilerplate\Models\Role[] $roles
 * @method static \Illuminate\Database\Query\Builder|\Sebastienheyd\Boilerplate\Models\Permission whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Sebastienheyd\Boilerplate\Models\Permission whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\Sebastienheyd\Boilerplate\Models\Permission whereDisplayName($value)
 * @method static \Illuminate\Database\Query\Builder|\Sebastienheyd\Boilerplate\Models\Permission whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Sebastienheyd\Boilerplate\Models\Permission whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\Sebastienheyd\Boilerplate\Models\Permission whereUpdatedAt($value)
 * @mixin \Eloquent
 */
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