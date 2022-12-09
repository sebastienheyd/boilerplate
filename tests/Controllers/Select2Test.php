<?php

namespace Sebastienheyd\Boilerplate\Tests\Controllers;

use Sebastienheyd\Boilerplate\Tests\factories\UserFactory;
use Sebastienheyd\Boilerplate\Tests\TestCase;

class Select2Test extends TestCase
{
    public function testSelect2NotAjax()
    {
        UserFactory::create()->admin(true);
        $resource = $this->post('admin/select2');
        $resource->assertNotFound();
    }

    public function testSelect2NoData()
    {
        UserFactory::create()->admin(true);
        $resource = $this->post('admin/select2', [], [
            'X-Requested-With' => 'XMLHttpRequest',
        ]);
        $resource->assertNotFound();
    }

    public function testSelect2BadData()
    {
        UserFactory::create()->admin(true);
        $resource = $this->post('admin/select2', [
            'm' => 'BadData',
        ], [
            'X-Requested-With' => 'XMLHttpRequest',
        ]);
        $resource->assertNotFound();

        $resource = $this->post('admin/select2', [
            'm' => encrypt('BadData'),
        ], [
            'X-Requested-With' => 'XMLHttpRequest',
        ]);
        $resource->assertNotFound();
    }

    public function testSelect2()
    {
        $user = UserFactory::create()->admin(true);

        $resource = $this->post('admin/select2', [
            'm' => encrypt('Sebastienheyd\Boilerplate\Models\User|email'),
        ], [
            'X-Requested-With' => 'XMLHttpRequest',
        ]);

        $content = $resource->getOriginalContent();

        $this->assertEquals($user->email, $content['results'][0]['text']);
    }

    public function testSelect2Key()
    {
        $user = UserFactory::create()->admin(true);

        $resource = $this->post('admin/select2', [
            'm' => encrypt('Sebastienheyd\Boilerplate\Models\User|first_name|email'),
        ], [
            'X-Requested-With' => 'XMLHttpRequest',
        ]);

        $content = $resource->getOriginalContent();

        $this->assertEquals($user->email, $content['results'][0]['id']);
        $this->assertEquals($user->first_name, $content['results'][0]['text']);
    }

    public function testSelect2Scope()
    {
        $user = UserFactory::create()->admin(true);

        $resource = $this->post('admin/select2', [
            'm' => encrypt('Sebastienheyd\Boilerplate\Tests\Models\User|FirstLastName'),
        ], [
            'X-Requested-With' => 'XMLHttpRequest',
        ]);

        $content = $resource->getOriginalContent();

        $this->assertEquals($user->first_name.' '.$user->last_name, $content['results'][0]['text']);
    }
}