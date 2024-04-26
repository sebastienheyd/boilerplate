<?php

namespace Sebastienheyd\Boilerplate\Tests\factories;

use Faker\Factory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Sebastienheyd\Boilerplate\Models\Role;
use Sebastienheyd\Boilerplate\Models\User;

class UserFactory
{
    private $faker;
    private static $instance;

    /**
     * @return self
     */
    public static function create()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function __construct()
    {
        $this->faker = Factory::create();
    }

    public function user($authUser = false)
    {
        $user = User::create([
            'active'            => '1',
            'first_name'        => str_replace("'", '', $this->faker->firstName),
            'last_name'         => str_replace("'", '', $this->faker->lastName),
            'email'             => $this->faker->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password'          => Hash::make('password'),
            'remember_token'    => Str::random(32),
        ]);

        if ($authUser) {
            Auth::setUser($user);
        }

        return $user;
    }

    public function backendUser($authUser = false)
    {
        $user = User::create([
            'active'            => '1',
            'first_name'        => str_replace("'", '', $this->faker->firstName),
            'last_name'         => str_replace("'", '', $this->faker->lastName),
            'email'             => $this->faker->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password'          => Hash::make('password'),
            'remember_token'    => Str::random(32),
        ]);

        $role = Role::find(2);
        $user->addRole($role);

        if ($authUser) {
            Auth::setUser($user);
        }

        return $user;
    }

    public function admin($authUser = false)
    {
        $user = DB::table('users')->insertGetId([
            'active'            => '1',
            'first_name'        => str_replace("'", '', $this->faker->firstName),
            'last_name'         => str_replace("'", '', mb_strtoupper($this->faker->lastName)),
            'email'             => $this->faker->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password'          => Hash::make('password'),
            'remember_token'    => Str::random(32),
        ]);

        $user = User::find($user);
        $role = Role::find(1);
        $user->addRole($role);

        if ($authUser) {
            Auth::setUser($user);
        }

        return $user;
    }
}
