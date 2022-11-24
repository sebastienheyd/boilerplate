<?php

namespace Sebastienheyd\Boilerplate\Tests\Controllers\Auth;

use Faker\Factory;
use Illuminate\Support\Facades\Auth;
use Sebastienheyd\Boilerplate\Tests\factories\UserFactory;
use Sebastienheyd\Boilerplate\Tests\TestCase;

class RegisterTest extends TestCase
{
    public function testRegisterForm()
    {
        $resource = $this->get('admin/register');
        $resource->assertSee('Enter the following fields to create a new user');
    }

    public function testRegisterFormWithUser()
    {
        $user = UserFactory::create()->admin();
        $resource = $this->get('admin/register');
        $resource->assertNotFound();

        config(['boilerplate.auth.register' => true]);
        $resource = $this->get('admin/register');
        $resource->assertSee('Enter the following fields to create a new user');
    }

    public function testRegisterPostFail()
    {
        $resource = $this->post('admin/register', []);

        $resource->assertSessionHasErrors([
            'last_name' => 'The last name field is required.',
            'first_name' => 'The first name field is required.',
            'email' => 'The email field is required.',
            'password' => 'The password field is required.',
        ]);
    }

    public function testRegisterPost()
    {
        $factory = Factory::create();

        $email = $factory->unique()->safeEmail();

        $resource = $this->post('admin/register', [
            'last_name' => $factory->lastName,
            'first_name' => $factory->firstName,
            'email' => $email,
            'password' => '#Password123',
            'password_confirmation' => '#Password123',
        ]);

        $resource->assertRedirect('http://localhost/admin');
        $this->assertTrue(Auth::user()->email === $email);
    }

    public function testRegisterPostNotFirstUser()
    {
        UserFactory::create()->admin();

        $factory = Factory::create();

        $resource = $this->post('admin/register', [
            'last_name' => $factory->lastName,
            'first_name' => $factory->firstName,
            'email' => $factory->unique()->safeEmail(),
            'password' => '#Password123',
            'password_confirmation' => '#Password123',
        ]);

        $resource->assertNotFound();
    }

    public function testRegisterPostNotFirstUserAndRegisterActive()
    {
        UserFactory::create()->admin();

        $factory = Factory::create();
        config(['boilerplate.auth.register' => true]);

        $email = $factory->unique()->safeEmail();

        $resource = $this->post('admin/register', [
            'last_name' => $factory->lastName,
            'first_name' => $factory->firstName,
            'email' => $email,
            'password' => '#Password123',
            'password_confirmation' => '#Password123',
        ]);

        $resource->assertRedirect('http://localhost/admin');
        $this->assertTrue(Auth::user()->email === $email);
    }
}