<?php

namespace Sebastienheyd\Boilerplate\Tests\factories;

use Faker\Factory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Sebastienheyd\Boilerplate\Models\Permission;
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
            'active' => '1',
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'email' => $this->faker->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
        ]);

        if ($authUser) {
            Auth::setUser($user);
        }

        return $user;
    }

    public function backendUser($authUser = false)
    {
        $user = User::create([
            'active' => '1',
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'email' => $this->faker->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
        ]);

        $role = Permission::find(1);
        $user->attachPermission($role);

        if ($authUser) {
            Auth::setUser($user);
        }

        return $user;
    }

    public function admin($authUser = false)
    {
        $user = DB::table('users')->insertGetId([
            'active' => '1',
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'email' => $this->faker->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
        ]);

        $user = User::find($user);
        $role = Role::find(1);
        $user->attachRole($role);

        if ($authUser) {
            Auth::setUser($user);
        }

        return $user;
    }
}
