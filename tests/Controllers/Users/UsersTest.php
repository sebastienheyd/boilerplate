<?php

namespace Sebastienheyd\Boilerplate\Tests\Controllers\Users;

use Illuminate\Http\UploadedFile;
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
            'The user will receive an invitation by e-mail to login in which it will allow him to enter his new password',
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
        $resource->assertRedirect('/admin/users/2/edit');

        $this->assertTrue($this->getMails()->count() === 1);

        $mail = $this->getLastMail();
        $this->assertTrue($mail['subject'] === 'Your account has been created on Boilerplate Test');
    }

    public function testUserEditForm()
    {
        $admin = UserFactory::create()->admin();
        $user = UserFactory::create()->backendUser();

        $resource = $this->actingAs($admin)->get('/admin/users/2/edit');
        $resource->assertStatus(200);
        $resource->assertSeeInOrder([
            'action="/admin/users/2"',
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
            '_method' => 'PUT',
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
        $resource->assertRedirect('/admin/users/2/edit');

        $user = User::find(2);
        $this->assertEquals('john.doe@email.tld', $user->email);
        $this->assertEquals('DOE', $user->last_name);
        $this->assertEquals('John', $user->first_name);
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
        $resource->assertJson(['success' => true]);
        $this->assertTrue(User::find(2) === null);
    }

    public function testUserFirstLogin()
    {
        UserFactory::create()->admin();
        $user = UserFactory::create()->backendUser();

        $resource = $this->get('admin/connect/'.$user->remember_token);
        $resource->assertStatus(200);
        $resource->assertSeeInOrder([
            'action="/admin/connect"',
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
            'token'     => 'The token field is required.',
            'password'  => 'The password field is required.',
        ]);
    }

    public function testUserFirstLoginPostSuccess()
    {
        UserFactory::create()->admin();
        $user = UserFactory::create()->backendUser();

        $resource = $this->post('admin/connect/'.$user->remember_token, [
            'token'                 => $user->remember_token,
            'password'              => '#Azerty123',
            'password_confirmation' => '#Azerty123',
        ]);

        $resource->assertStatus(302);
        $resource->assertRedirect('/admin');
        $this->assertTrue(Hash::check('#Azerty123', User::find(2)->password));
    }

    public function testUserProfile()
    {
        UserFactory::create()->admin();
        $user = UserFactory::create()->backendUser();

        $resource = $this->actingAs($user)->get('admin/userprofile');

        $resource->assertStatus(200);
        $resource->assertSeeInOrder([
            'action="/admin/userprofile"',
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
            'first_name'            => 'John',
            'last_name'             => 'Doe',
            'password'              => '#Azerty123',
            'password_confirmation' => '#Azerty123',
        ]);

        $resource->assertStatus(302);
        $resource->assertRedirect('/admin/userprofile');

        $user = User::find(2);
        $this->assertEquals('DOE', $user->last_name);
        $this->assertEquals('John', $user->first_name);
        $this->assertTrue(Hash::check('#Azerty123', $user->password));
    }

    public function testAvatarUrl()
    {
        UserFactory::create()->admin();
        $user = UserFactory::create()->backendUser();

        $resource = $this->actingAs($user)->get('admin/userprofile/avatar/url');

        $resource->assertStatus(200);
        $name = http_build_query(['name' => $user->first_name.' '.$user->last_name]);
        $this->assertEquals('https://ui-avatars.com/api/?background=F0F0F0&color=333&size=170&'.$name, $resource->content());
    }

    public function testAvatarDelete()
    {
        UserFactory::create()->admin();
        $user = UserFactory::create()->backendUser();

        $resource = $this->actingAs($user)->post('admin/userprofile/avatar/delete');

        $resource->assertStatus(200);
        $resource->assertJson(['success' => false]);
    }

    public function testAvatarUpload()
    {
        UserFactory::create()->admin();
        $user = UserFactory::create()->backendUser();

        $resource = $this->actingAs($user)->post('admin/userprofile/avatar/upload');
        $resource->assertStatus(200);
        $resource->assertJson([
            'success' => false,
            'message' => 'The avatar field is required.',
        ]);

        $resource = $this->actingAs($user)->post('admin/userprofile/avatar/upload', [
            'avatar' => 'badValue',
        ]);
        $resource->assertStatus(200);

        $resource->assertJson([
            'success' => false,
            'message' => 'The avatar must be a file of type: jpeg, jpg, png.',
        ]);

        $resource = $this->actingAs($user)->post('admin/userprofile/avatar/upload', [
            'avatar' => UploadedFile::fake()->image('avatar.jpg', 500, 500),
        ]);

        $resource->assertStatus(200);
        $resource->assertJson(['success' => true]);

        $this->assertTrue($user->hasAvatar());
    }

    public function testAvatarFromGravatar()
    {
        UserFactory::create()->admin();
        $user = UserFactory::create()->backendUser();

        $resource = $this->actingAs($user)->post('admin/userprofile/avatar/gravatar');

        $resource->assertStatus(200);
        $resource->assertJson(['success' => false]);
    }

    public function testStoreSetting()
    {
        UserFactory::create()->admin();
        $user = UserFactory::create()->backendUser();

        $resource = $this->actingAs($user)->post('admin/userprofile/settings');
        $resource->assertStatus(404);

        $resource = $this->actingAs($user)->post('admin/userprofile/settings', [], ['X-Requested-With' => 'XMLHttpRequest']);
        $resource->assertStatus(200);
        $resource->assertJson(['success' => false]);

        $resource = $this->actingAs($user)->post('admin/userprofile/settings', ['name' => 'test'], ['X-Requested-With' => 'XMLHttpRequest']);
        $resource->assertStatus(200);
        $resource->assertJson(['success' => false]);

        $resource = $this->actingAs($user)->post('admin/userprofile/settings', ['value' => 'test'], ['X-Requested-With' => 'XMLHttpRequest']);
        $resource->assertStatus(200);
        $resource->assertJson(['success' => false]);

        $resource = $this->actingAs($user)->post('admin/userprofile/settings', [
            'name'  => 'test',
            'value' => 'test',
        ], ['X-Requested-With' => 'XMLHttpRequest']);
        $resource->assertStatus(200);
        $resource->assertJson(['success' => true]);

        $this->assertEquals('test', $user->setting('test'));
    }

    public function testKeepAlive()
    {
        UserFactory::create()->admin();
        $user = UserFactory::create()->backendUser();

        $sessionId = session()->getId();

        $resource = $this->actingAs($user)->post('admin/keep-alive', ['id' => $sessionId]);
        $resource->assertStatus(200);

        $this->assertEquals($sessionId, session()->getId());
    }
}
