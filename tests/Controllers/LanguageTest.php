<?php

namespace Sebastienheyd\Boilerplate\Tests\Controllers;

use Sebastienheyd\Boilerplate\Tests\factories\UserFactory;
use Sebastienheyd\Boilerplate\Tests\TestCase;

class LanguageTest extends TestCase
{
    public function testLanguageSwitchNotActive()
    {
        config(['boilerplate.locale.switch' => false]);
        UserFactory::create()->admin(true);

        $resource = $this->post('admin/language', [
            'lang' => 'xx',
        ]);

        $resource->assertRedirect('http://localhost');
        $this->assertNull(setting('locale'));

        $resource = $this->get('admin');
        $this->assertEquals('en', $this->app->getLocale());
    }

    public function testLanguageSwitchFail()
    {
        UserFactory::create()->admin(true);

        $resource = $this->post('admin/language', [
            'lang' => 'xx',
        ]);

        $resource->assertRedirect('http://localhost');
        $this->assertNull(setting('locale'));

        $resource = $this->get('admin');
        $this->assertEquals('en', $this->app->getLocale());
    }

    public function testLanguageSwitch()
    {
        UserFactory::create()->admin(true);
        $resource = $this->post('admin/language', [
            'lang' => 'fr',
        ]);

        $resource->assertCookie('boilerplate_lang');
        $resource->assertRedirect('http://localhost');
        $this->assertEquals('fr', setting('locale'));

        $resource = $this->get('admin');
        $this->assertEquals('fr', $this->app->getLocale());
    }
}
