<?php

namespace Sebastienheyd\Boilerplate\Tests\Controllers\Auth;

use Illuminate\Support\Str;
use Sebastienheyd\Boilerplate\Tests\factories\UserFactory;
use Sebastienheyd\Boilerplate\Tests\TestCase;

class ResetPasswordTest extends TestCase
{
    public function testResetPasswordUserLogged()
    {
        $user = UserFactory::create()->admin(true);
        $token = Str::random(60);
        $user->setRememberToken($token);
        $user->save();

        $resource = $this->get('admin/password/reset/'.$token);
        $resource->assertRedirect('http://localhost/admin');
    }

    public function testResetPassword()
    {
        $user = UserFactory::create()->admin();
        $token = Str::random(60);
        $user->setRememberToken($token);
        $user->save();

        $resource = $this->get('admin/password/reset/'.$token);
        $resource->assertSee('Enter the following fields to reset your password');
    }

    public function testResetPasswordPost()
    {
        $user = UserFactory::create()->admin();
        $token = Str::random(60);
        $user->setRememberToken($token);
        $user->save();

        $resource = $this->post('admin/password/reset');
        $resource->assertSessionHasErrors([
            'token' => 'The token field is required.',
            'email' => 'The email field is required.',
            'password' => 'The password field is required.',
        ]);
    }
}
