<?php

namespace Sebastienheyd\Boilerplate\Models;

// phpcs:disable Generic.Files.LineLength

use Carbon\Carbon;
use Gravatar;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laratrust\Traits\LaratrustUserTrait;
use Sebastienheyd\Boilerplate\Events\UserCreated;
use Sebastienheyd\Boilerplate\Events\UserDeleted;
use Sebastienheyd\Boilerplate\Notifications\NewUser as NewUserNotification;
use Sebastienheyd\Boilerplate\Notifications\ResetPassword as ResetPasswordNotification;

/**
 * Sebastienheyd\Boilerplate\Models\User.
 *
 * @property int            $id
 * @property bool           $active
 * @property string         $first_name
 * @property string         $last_name
 * @property string         $email
 * @property string         $password
 * @property string         $remember_token
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string         $deleted_at
 * @property string         $last_login
 * @property-read string|false $avatar_path
 * @property-read string $avatar_url
 * @property-read mixed $name
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read \Illuminate\Database\Eloquent\Collection|\Sebastienheyd\Boilerplate\Models\Permission[] $permissions
 * @property-read \Illuminate\Database\Eloquent\Collection|\Sebastienheyd\Boilerplate\Models\Role[] $roles
 *
 * @method static \Illuminate\Database\Query\Builder|\Sebastienheyd\Boilerplate\Models\User whereActive($value)
 * @method static \Illuminate\Database\Query\Builder|\Sebastienheyd\Boilerplate\Models\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Sebastienheyd\Boilerplate\Models\User whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Sebastienheyd\Boilerplate\Models\User whereEmail($value)
 * @method static \Illuminate\Database\Query\Builder|\Sebastienheyd\Boilerplate\Models\User whereFirstName($value)
 * @method static \Illuminate\Database\Query\Builder|\Sebastienheyd\Boilerplate\Models\User whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Sebastienheyd\Boilerplate\Models\User whereLastLogin($value)
 * @method static \Illuminate\Database\Query\Builder|\Sebastienheyd\Boilerplate\Models\User whereLastName($value)
 * @method static \Illuminate\Database\Query\Builder|\Sebastienheyd\Boilerplate\Models\User wherePassword($value)
 * @method static \Illuminate\Database\Query\Builder|\Sebastienheyd\Boilerplate\Models\User whereRememberToken($value)
 * @method static \Illuminate\Database\Query\Builder|\Sebastienheyd\Boilerplate\Models\User whereRoleIs($role = '')
 * @method static \Illuminate\Database\Query\Builder|\Sebastienheyd\Boilerplate\Models\User whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class User extends Authenticatable
{
    use Notifiable;
    use LaratrustUserTrait;
    use SoftDeletes;

    protected $fillable = ['active', 'last_name', 'first_name', 'email', 'password', 'remember_token', 'last_login'];
    protected $hidden = ['password', 'remember_token'];

    protected $dispatchesEvents = [
        'forceDeleted' => UserDeleted::class,
        'created'      => UserCreated::class,
    ];

    /**
     * Send the password reset notification.
     *
     * @param string $token
     *
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }

    /**
     * Send notification when a new user is created.
     *
     * @param string $token
     */
    public function sendNewUserNotification($token)
    {
        $this->notify(new NewUserNotification($token, $this));
    }

    /**
     * Return last name in uppercase by default.
     *
     * @param $value
     *
     * @return string
     */
    public function getLastNameAttribute($value)
    {
        return mb_strtoupper($value);
    }

    /**
     * Return first name with first char of every word in uppercase.
     *
     * @param $value
     *
     * @return string
     */
    public function getFirstNameAttribute($value)
    {
        return mb_convert_case($value, MB_CASE_TITLE);
    }

    /**
     * Return a concatenation of first name and last_name if field name does not exists.
     *
     * @param $value
     *
     * @return string
     */
    public function getNameAttribute($value)
    {
        if (! empty($value)) {
            return $value;
        }

        return $this->first_name.' '.$this->last_name;
    }

    /**
     * Return last login date formatted.
     *
     * @param string $format
     * @param string $default
     *
     * @return mixed|string
     */
    public function getLastLogin($format = 'YYYY-MM-DD HH:mm:ss', $default = '')
    {
        if ($this->last_login === null) {
            return $default;
        }

        return Carbon::createFromTimeString($this->last_login)->isoFormat($format);
    }

    /**
     * Return role list as a string.
     *
     * @return string
     */
    public function getRolesList()
    {
        $res = [];
        foreach ($this->roles as $role) {
            $res[] = __($role->display_name);
        }
        if (empty($res)) {
            return '-';
        }

        return implode(', ', $res);
    }

    /**
     * Return true if user has an avatar image.
     *
     * @return bool
     */
    public function hasAvatar()
    {
        return is_file($this->getAvatarPathAttribute());
    }

    /**
     * Check if current user has an avatar.
     *
     * @return string|false
     */
    public function getAvatarPathAttribute()
    {
        return public_path('images/avatars/'.md5($this->id.$this->email).'.jpg');
    }

    /**
     * Delete avatar image.
     *
     * @return bool
     */
    public function deleteAvatar()
    {
        if ($this->hasAvatar()) {
            return unlink($this->getAvatarPathAttribute());
        }

        return false;
    }

    /**
     * Return current user avatar uri.
     *
     * @return string
     */
    public function getAvatarUrlAttribute()
    {
        if (is_file($this->avatar_path)) {
            $ts = filemtime($this->avatar_path);

            return asset('images/avatars/'.md5($this->id.$this->email).'.jpg?t='.$ts);
        }

        return asset('/assets/vendor/boilerplate/images/default-user.png');
    }

    /**
     * Get avatar image from Gravatar.com.
     *
     * @return bool
     */
    public function getAvatarFromGravatar()
    {
        if (! Gravatar::exists($this->getAttribute('email'))) {
            return false;
        }

        if ($this->hasAvatar()) {
            unlink($this->getAvatarPathAttribute());
        }

        $src = Gravatar::src($this->getAttribute('email'), 250);
        $img = file_get_contents($src);
        $destDir = public_path('images/avatars/');

        if (! is_dir($destDir)) {
            mkdir($destDir, 0766, true);
        }

        file_put_contents($this->getAvatarPathAttribute(), $img);

        return true;
    }
}
