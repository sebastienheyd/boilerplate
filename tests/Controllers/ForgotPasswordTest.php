<?php

namespace Sebastienheyd\Boilerplate\Tests\Controllers;

use Sebastienheyd\Boilerplate\Tests\factories\UserFactory;
use Sebastienheyd\Boilerplate\Tests\TestCase;

class ForgotPasswordTest extends TestCase
{
    public function testForgotPasswordNoUser()
    {
        $resource = $this->get('admin/password/request');
        $resource->assertRedirect('http://localhost/admin/register');
    }

    public function testForgotPassword()
    {
        UserFactory::create()->admin();
        $resource = $this->get('admin/password/request');

        $resource->assertSee('Enter the following field to reset your password');
    }
}