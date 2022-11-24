<?php

namespace Sebastienheyd\Boilerplate\Tests\Controllers\Users;

use Illuminate\Support\Facades\Hash;
use Sebastienheyd\Boilerplate\Models\User;
use Sebastienheyd\Boilerplate\Tests\factories\UserFactory;
use Sebastienheyd\Boilerplate\Tests\TestCase;

class UsersTest extends TestCase
{
    protected $admin;
    protected $user;

    protected function setUp(): void
    {
        parent::setUp();
    }

    public function testUsers()
    {
        $admin = UserFactory::create()->admin();
        $resource = $this->actingAs($admin)->get('admin/users');
        $resource->assertStatus(200);
        $resource->assertSeeTextInOrder(['Users', 'User list']);
    }

    public function testUsersNoPermission()
    {
        $user = UserFactory::create()->backendUser();
        $resource = $this->actingAs($user)->get('admin/users');
        $resource->assertStatus(403);
    }

    public function testUserCreateForm()
    {
        $admin = UserFactory::create()->admin();

        $resource = $this->actingAs($admin)->get('admin/users/create');
        $resource->assertStatus(200);
        $resource->assertSeeInOrder([
            'Users',
            'Add a user',
            '<h3 class="card-title">Informations</h3>',
            'The user will receive an invitation by e-mail to login in which it will allow him to enter his new password'
        ], false);
    }

    public function testUserCreateFormPostFail()
    {
        $admin = UserFactory::create()->admin();
        $resource = $this->actingAs($admin)->post('admin/users');

        $resource->assertSessionHasErrors([
            'last_name'  => 'The last name field is required.',
            'first_name' => 'The first name field is required.',
            'email'      => 'The email field is required.',
        ]);
    }

    public function testUserCreateFormPost()
    {
        $admin = UserFactory::create()->admin();
        $resource = $this->actingAs($admin)->post('admin/users', [
            'last_name'  => 'Doe',
            'first_name' => 'John',
            'email'      => 'john.doe@email.tld',
        ]);

        $user = User::whereEmail('john.doe@email.tld')->first();
        $this->assertTrue($user !== null);
        $resource->assertStatus(302);
        $resource->assertRedirect('http://localhost/admin/users/2/edit');

        $mail = $this->getLastMail();
        $this->assertTrue($mail->getSubject() === 'Your account has been created on Boilerplate Test');
    }

    public function testUserEditForm()
    {
        $admin = UserFactory::create()->admin();
        $user = UserFactory::create()->backendUser();

        $resource = $this->actingAs($admin)->get('http://localhost/admin/users/2/edit');
        $resource->assertStatus(200);
        $resource->assertSeeInOrder([
            'action="http://localhost/admin/users/2"',
            'value="'.$user->email.'"',
            'value="'.$user->first_name.'"',
            'value="'.$user->last_name.'"',
        ], false);
    }

    public function testUserEditFormPostFail()
    {
        $admin = UserFactory::create()->admin();
        UserFactory::create()->backendUser();

        $resource = $this->actingAs($admin)->post('admin/users/2', [
            '_method' => 'PUT'
        ]);

        $resource->assertSessionHasErrors([
            'last_name'  => 'The last name field is required.',
            'first_name' => 'The first name field is required.',
            'email'      => 'The email field is required.',
        ]);
    }

    public function testUserEditFormPost()
    {
        $admin = UserFactory::create()->admin();
        UserFactory::create()->backendUser();

        $resource = $this->actingAs($admin)->post('admin/users/2', [
            '_method'    => 'PUT',
            'last_name'  => 'Doe',
            'first_name' => 'John',
            'email'      => 'john.doe@email.tld',
        ]);

        $resource->assertStatus(302);
        $resource->assertRedirect('http://localhost/admin/users/2/edit');

        $user = User::find(2);
        $this->assertTrue($user->email === 'john.doe@email.tld');
        $this->assertTrue($user->last_name === 'DOE');
        $this->assertTrue($user->first_name === 'John');
    }

    public function testUserDestroy()
    {
        $admin = UserFactory::create()->admin();
        UserFactory::create()->backendUser();

        $this->assertTrue(User::find(2) !== null);

        $resource = $this->actingAs($admin)->post('admin/users/2', [
            '_method' => 'DELETE',
        ]);

        $resource->assertStatus(200);
        $this->assertTrue(User::find(2) === null);
        $this->assertTrue($resource->content() === '{"success":true}');
    }

    public function testUserFirstLogin()
    {
        UserFactory::create()->admin();
        $user = UserFactory::create()->backendUser();

        $resource = $this->get('admin/connect/'.$user->remember_token);
        $resource->assertStatus(200);
        $resource->assertSeeInOrder([
            'action="http://localhost/admin/connect"',
            'name="token" value="'.$user->remember_token.'"',
            'name="password"',
            'name="password_confirmation"',
        ], false);
    }

    public function testUserFirstLoginPostFail()
    {
        UserFactory::create()->admin();
        $user = UserFactory::create()->backendUser();

        $resource = $this->post('admin/connect/'.$user->remember_token);

        $resource->assertSessionHasErrors([
            'token'  => 'The token field is required.',
            'password'  => 'The password field is required.',
        ]);
    }

    public function testUserFirstLoginPostSuccess()
    {
        UserFactory::create()->admin();
        $user = UserFactory::create()->backendUser();

        $resource = $this->post('admin/connect/'.$user->remember_token, [
            'token' => $user->remember_token,
            'password' => '#Azerty123',
            'password_confirmation' => '#Azerty123',
        ]);

        $resource->assertStatus(302);
        $resource->assertRedirect('http://localhost/admin');
        $this->assertTrue(Hash::check('#Azerty123', User::find(2)->password));
    }

    public function testUserProfile()
    {
        UserFactory::create()->admin();
        $user = UserFactory::create()->backendUser();

        $resource = $this->actingAs($user)->get('admin/userprofile');

        $resource->assertStatus(200);
        $resource->assertSeeInOrder([
            'action="http://localhost/admin/userprofile"',
            '<h3 class="card-title">My profile</h3>',
            '<strong class="h3">'.$user->first_name.' '.$user->last_name.'</strong>',
            $user->email,
        ], false);
    }

    public function testUserProfilePostFail()
    {
        UserFactory::create()->admin();
        $user = UserFactory::create()->backendUser();

        $resource = $this->actingAs($user)->post('admin/userprofile');

        $resource->assertStatus(302);
        $resource->assertSessionHasErrors([
            'last_name'  => 'The last name field is required.',
            'first_name' => 'The first name field is required.',
        ]);
    }

    public function testUserProfilePostSuccess()
    {
        UserFactory::create()->admin();
        $user = UserFactory::create()->backendUser();

        $resource = $this->actingAs($user)->post('admin/userprofile', [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'password' => '#Azerty123',
            'password_confirmation' => '#Azerty123',
        ]);

        $resource->assertStatus(302);
        $resource->assertRedirect('http://localhost/admin/userprofile');

        $user = User::find(2);
        $this->assertTrue($user->last_name === 'DOE');
        $this->assertTrue($user->first_name === 'John');
        $this->assertTrue(Hash::check('#Azerty123', $user->password));
    }
}