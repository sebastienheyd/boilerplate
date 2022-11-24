<?php

namespace Sebastienheyd\Boilerplate\Tests\Controllers\Auth;

use Illuminate\Support\Facades\Auth;
use Sebastienheyd\Boilerplate\Tests\factories\UserFactory;
use Sebastienheyd\Boilerplate\Tests\TestCase;

class LoginTest extends TestCase
{
    public function testLoginNoUser()
    {
        $resource = $this->get('admin/login');
        $resource->assertRedirect('http://localhost/admin/register');
    }

    public function testLoginForm()
    {
        UserFactory::create()->admin();
        $resource = $this->get('admin/login');

        $resource->assertSee('Sign in to start your session');
        $resource->assertSee('<a href="http://localhost/admin/password/request">I forgot my password</a>', false);
    }

    public function testLoginFormPostValidation()
    {
        UserFactory::create()->admin();
        $resource = $this->post('admin/login', []);

        $resource->assertSessionHasErrors([
            'email' => 'The email field is required.',
            'password' => 'The password field is required.',
        ]);
    }

    public function testLoginFormPostFail()
    {
        $user = UserFactory::create()->admin();
        $resource = $this->post('admin/login', ['email' => $user->email, 'password' => 'bad']);

        $resource->assertSessionHasErrors([
            'email' => 'These credentials do not match our records.',
        ]);
    }

    public function testLoginFormPost()
    {
        $user = UserFactory::create()->admin();
        $resource = $this->post('admin/login', ['email' => $user->email, 'password' => 'password']);

        $resource->assertRedirect('http://localhost/admin');
        $this->assertTrue(Auth::user()->email === $user->email);
    }

    public function testLoginFormAlreadyConnected()
    {
        $user = UserFactory::create()->admin();
        $resource = $this->actingAs($user)->get('admin/login');

        $resource->assertRedirect('http://localhost/admin');
        $this->assertTrue(Auth::user()->email === $user->email);
    }

    public function testLogoutPostAsNotConnected()
    {
        $resource =  $this->post('admin/logout');

        $resource->assertRedirect('http://localhost/admin/login');
    }

    public function testLogoutPost()
    {
        $user = UserFactory::create()->admin();
        $resource =  $this->actingAs($user)->post('admin/logout');

        $resource->assertRedirect('http://localhost/admin/login');
        $this->assertTrue(Auth::user() === null);
    }
}