<?php

namespace Sebastienheyd\Boilerplate\Models;

use Laratrust\LaratrustRole;
use Sebastienheyd\Boilerplate\Models\User;

/**
 * Sebastienheyd\Boilerplate\Models\Role
 *
 * @property int $id
 * @property string $name
 * @property string $display_name
 * @property string $description
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\Sebastienheyd\Boilerplate\Models\Permission[] $permissions
 * @method static \Illuminate\Database\Query\Builder|\Sebastienheyd\Boilerplate\Models\Role whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Sebastienheyd\Boilerplate\Models\Role whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\Sebastienheyd\Boilerplate\Models\Role whereDisplayName($value)
 * @method static \Illuminate\Database\Query\Builder|\Sebastienheyd\Boilerplate\Models\Role whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Sebastienheyd\Boilerplate\Models\Role whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\Sebastienheyd\Boilerplate\Models\Role whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Role extends LaratrustRole
{
    protected $fillable = [ 'name', 'display_name', 'description' ];

    public function getDisplayNameAttribute($value)
    {
        return __($value);
    }

    public function getDescriptionAttribute($value)
    {
        return __($value);
    }

    public function getNbUsers()
    {
        return User::whereRoleIs($this->name)->count();
    }
}