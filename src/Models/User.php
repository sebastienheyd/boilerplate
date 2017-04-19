<?php

namespace Sebastienheyd\Boilerplate\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Jenssegers\Date\Date as Date;
use Laratrust\Traits\LaratrustUserTrait;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Sebastienheyd\Boilerplate\Notifications\ResetPassword as ResetPasswordNotification;
use Sebastienheyd\Boilerplate\Notifications\NewUser as NewUserNotification;

class User extends Authenticatable
{
    use Notifiable;
    use LaratrustUserTrait;
    use SoftDeletes;

    protected $fillable = [ 'active', 'last_name', 'first_name', 'email', 'password', 'remember_token', 'last_login' ];
    protected $hidden = [ 'password', 'remember_token' ];

    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }

    /**
     * Send notification when a new user is created
     *
     * @param string $token
     */
    public function sendNewUserNotification($token)
    {
        $this->notify(new NewUserNotification($token, $this));
    }

    /**
     * Return last name in uppercase by default
     *
     * @param $value
     * @return string
     */
    public function getLastNameAttribute($value)
    {
        return mb_strtoupper($value);
    }

    /**
     * Return first name with first char of every word in uppercase
     *
     * @param $value
     * @return string
     */
    public function getFirstNameAttribute($value)
    {
        return mb_convert_case($value, MB_CASE_TITLE);
    }

    /**
     * Return instance of Jenssegers\Date\Date
     *
     * @param $value
     * @return \Jenssegers\Date\Date
     */
    public function getCreatedAtAttribute($value)
    {
        return Date::parse($value);
    }

    public function getNameAttribute()
    {
        return $this->first_name.' '.$this->last_name;
    }

    /**
     * Return last login date formatted
     *
     * @param string $format
     * @param string $default
     * @return mixed|string
     */
    public function getLastLogin($format = 'Y-m-d H:i:s', $default = '')
    {
        if ($this->last_login === null) return $default;
        return Date::parse($this->last_login)->format($format);
    }

    /**
     * Return role list as a string
     *
     * @return string
     */
    public function getRolesList()
    {
        $res = [ ];
        foreach ($this->roles as $role) { $res[ ] = __($role->display_name); }
        if (empty($res)) return '-';
        return join(', ', $res);
    }

    /**
     * Check if current user has an avatar
     *
     * @return string|false
     */
    public function getAvatarPathAttribute()
    {
        return public_path('images/avatars/'.md5($this->id.$this->email).'.jpg');
    }

    /**
     * Return current user avatar uri
     *
     * @return string
     */
    public function getAvatarUrlAttribute()
    {
        if (is_file($this->avatar_path)) {
            $ts = filemtime($this->avatar_path);
            return asset('images/avatars/'.md5($this->id.$this->email).'.jpg?t='.$ts);
        }
        return asset("/images/default_user.png");
    }
}
