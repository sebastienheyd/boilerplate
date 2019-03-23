<?php

namespace Tests\Browser;

use Faker\Factory;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

/**
 * Class DuskTest.
 *
 * @property Faker\Factory $faker
 * @property Browser $browser
 */
class DuskTest extends DuskTestCase
{
    use DatabaseMigrations;

    public function testBoilerplate()
    {
        $this->faker = Factory::create();

        $this->email = $this->faker->email;
        $this->password = $this->faker->password;

        $this->browse(function (Browser $browser) {
            $this->browser = $browser;

            $browser->maximize();

            $this->register();
            $this->addRole();
            $this->deleteRole();
            $this->createUser();
            $this->listUsers();
            $this->updateProfile();
            $this->logout();
            $this->passwordForgot();
            $this->login();
            $this->deleteUser();
            $this->registerAgain();
        });
    }

    private function register()
    {
        // Register a new user
        $this->browser->visit('/admin')->pause(1000)
            ->assertPathIs('/admin/register')
            ->type('first_name', $this->faker->firstName)
            ->type('last_name', $this->faker->lastName)
            ->type('email', $this->email)
            ->type('password', $this->password)
            ->type('password_confirmation', $this->password)
            ->press('Register')
            ->assertPathIs('/admin');
    }

    private function addRole()
    {
        $this->browser->visit('/admin/roles')
            ->clickLink('Add a role')
            ->assertPathIs('/admin/roles/create')
            ->type('display_name', 'Test users')
            ->type('description', 'Only for test purposes')
            ->click('label[for="permission_1"]')
            ->click('label[for="permission_2"]')
            ->press('Save')
            ->waitFor('.alert')
            ->assertPathIs('/admin/roles/3/edit')
            ->clickLink('Role list')
            ->waitFor('.dataTable')
            ->assertSee('Showing 1 to 3 of 3 entries')
            ->assertSee('Test users')
            ->assertSee('User management');
    }

    private function deleteRole()
    {
        $this->browser->visit('/admin/roles')
            ->click('a.destroy[href$="2"]')
            ->waitFor('.bootbox-confirm')
            ->click('.bootbox-confirm .btn-primary')
            ->waitFor('.dataTable');
    }

    private function createUser()
    {
        $this->browser->visit('/admin/users/create')
            ->type('last_name', 'Test')
            ->type('first_name', 'User')
            ->type('email', 'test@test.tld')
            ->click('label[for="role_3"]')
            ->press('Save')
            ->assertPathIs('/admin/users/2/edit');
    }

    private function listUsers()
    {
        $this->browser->visit('/admin/users')
            ->waitFor('.dataTable')
            ->assertSee($this->email)
            ->assertSee('test@test.tld')
            ->assertSee('Test users')
            ->assertSee('Showing 1 to 2 of 2 entries');
    }

    private function updateProfile()
    {
        $this->password = $this->faker->password;

        $this->browser->visit('/admin/userprofile')
            ->assertSee('Profile image')
            ->type('password', $this->password)
            ->type('password_confirmation', $this->password)
            ->press('Save')
            ->waitFor('.alert-success')
            ->assertSee('The profile has been correctly updated');
    }

    private function logout()
    {
        $this->browser->visit('/admin')
            ->click('.logout')
            ->waitFor('.bootbox-confirm')
            ->click('.bootbox-confirm .btn-primary')
            ->assertPathIs('/admin/login')
            ->assertSee('Sign in to start your session');
    }

    private function passwordForgot()
    {
        $this->browser->visit('/admin/login')
            ->clickLink('I forgot my password')
            ->assertPathIs('/admin/password/request')
            ->type('email', 'fake@fake.tld')
            ->press('Send reset link')
            ->assertSee("We can't find a user with that e-mail address.")
            ->type('email', 'test@test.tld')
            ->press('Send reset link')
            ->assertSee('We have e-mailed your password reset link!')
            ->clickLink('Sign in with an existing user')
            ->assertPathIs('/admin/login');
    }

    private function login()
    {
        $this->browser->visit('/admin')
            ->assertPathIs('/admin/login')
            ->type('email', $this->email)
            ->type('password', $this->password)
            ->press('Sign in')
            ->assertPathIs('/admin');
    }

    private function deleteUser()
    {
        $this->browser->visit('/admin/users')
            ->waitFor('.dataTable')
            ->click('a.destroy[href$="users/2"]')
            ->waitFor('.bootbox-confirm')
            ->click('.bootbox-confirm .btn-primary')
            ->pause(250)
            ->assertSee('Showing 1 to 1 of 1 entries');
    }

    private function registerAgain()
    {
        $this->browser->visit('/admin/register')
            ->assertPathIs('/admin/register')
            ->assertSee('404');
    }
}
