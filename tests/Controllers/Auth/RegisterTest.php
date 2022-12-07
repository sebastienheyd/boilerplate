<?php

namespace Sebastienheyd\Boilerplate\Tests\Controllers\Auth;

use Faker\Factory;
use Illuminate\Support\Facades\Auth;
use Sebastienheyd\Boilerplate\Models\User;
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
        $this->assertEquals($email, Auth::user()->email);
        $this->assertNull($this->getLastMail());
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
        $this->assertEquals($email, Auth::user()->email);
        $this->assertNull($this->getLastMail());
    }

    public function testRegisterEmailVerify()
    {
        UserFactory::create()->admin();

        $factory = Factory::create();

        config([
            'boilerplate.auth.verify_email' => true,
            'boilerplate.auth.register' => true
        ]);

        $email = $factory->unique()->safeEmail();

        $resource = $this->post('admin/register', [
            'last_name' => $factory->lastName,
            'first_name' => $factory->firstName,
            'email' => $email,
            'password' => '#Password123',
            'password_confirmation' => '#Password123',
        ]);

        $resource->assertRedirect('http://localhost/admin');
        $this->assertEquals($email, Auth::user()->email);

        $email = $this->getLastMail();
        $regex = '#(http:\/\/localhost\/admin\/email\/verify\/2\/([^?]+)\?expires=([^&]+)&amp;signature=([^\r\n]+))$#m';
        $this->assertTrue(preg_match($regex, $email['body'], $m) == 1);

        $resource = $this->get('admin');
        $resource->assertRedirect('http://localhost/admin/email/verify');

        $resource = $this->get('admin/email/verify');
        $resource->assertSeeInOrder([
            'Thanks for signing up!',
            'action="http://localhost/admin/email/verification-notification"',
            'Resend Verification Email'
        ], false);

        $resource = $this->post('admin/email/verification-notification', [
            'token' => Auth::user()->getRememberToken()
        ]);
        $resource->assertRedirect('http://localhost/admin/email/verify');
        $resource->assertSessionHas(['message' => 'Verification link sent!']);
        $this->assertTrue($this->getMails()->count() === 2);

        $this->assertNull(User::find(2)->email_verified_at);
        $resource = $this->get($m[1]);
        $resource->assertRedirect('http://localhost/admin');
        $this->assertNotNull(User::find(2)->email_verified_at);

        $resource = $this->get('admin/email/verify');
        $resource->assertRedirect('http://localhost/admin');
    }
}