<?php

namespace Workbench\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Sebastienheyd\Boilerplate\Models\Role;
use Sebastienheyd\Boilerplate\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Credentials of the demo administrator, also prefilled on the demo login page.
     */
    public const EMAIL = 'admin@example.com';
    public const PASSWORD = 'password';

    /**
     * Create the demo administrator used by composer serve.
     *
     * @return void
     */
    public function run(): void
    {
        $user = User::create([
            'active'     => true,
            'first_name' => 'Admin',
            'last_name'  => 'Demo',
            'email'      => self::EMAIL,
            'password'   => Hash::make(self::PASSWORD),
        ]);

        $user->forceFill(['email_verified_at' => now()])->save();
        $user->addRole(Role::where('name', 'admin')->firstOrFail());
    }
}
