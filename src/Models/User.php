<?php

namespace Sebastienheyd\Boilerplate\Models;

use Illuminate\Notifications\Notifiable;
use Jenssegers\Date\Date;
use Laratrust\Traits\LaratrustUserTrait;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Sebastienheyd\Boilerplate\Notifications\ResetPassword as ResetPasswordNotification;
use Sebastienheyd\Boilerplate\Notifications\NewUser as NewUserNotification;

class User extends Authenticatable
{
    use Notifiable;
    use LaratrustUserTrait;

    protected $fillable = ['active', 'last_name', 'first_name', 'email', 'password', 'remember_token'];
    protected $hidden = ['password', 'remember_token'];

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

    public function sendNewUserNotification($token)
    {
        $this->notify(new NewUserNotification($token, $this));
    }

    public function getLastNameAttribute($value)
    {
        return mb_strtoupper($value);
    }

    public function getFirstNameAttribute($value)
    {
        return mb_convert_case($value, MB_CASE_TITLE);
    }

    public function getCreatedAtAttribute($value)
    {
        return Date::parse($value);
    }

    public function getRolesList()
    {
        $res = [];
        foreach ($this->roles as $role) { $res[] = __($role->display_name); }
        if(empty($res)) return '-';
        return join(', ', $res);
    }
}
