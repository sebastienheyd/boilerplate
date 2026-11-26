<?php

namespace Sebastienheyd\Boilerplate\Tests\View;

use Illuminate\Support\Facades\View;
use Sebastienheyd\Boilerplate\Tests\factories\UserFactory;
use Sebastienheyd\Boilerplate\Tests\TestCase;
use Workbench\App\Providers\WorkbenchServiceProvider;
use Workbench\Database\Seeders\DatabaseSeeder;

class LoginNoticeTest extends TestCase
{
    public function testLoginNoticeStackIsRenderedInTheLoginBox()
    {
        View::composer('boilerplate::auth.login', function () {
            View::startPush('login-notice', '<p id="custom-notice">Notice</p>');
        });
        UserFactory::create()->admin();
        $html = $this->get('admin/login')->getContent();
        $notice = strpos($html, '<p id="custom-notice">Notice</p>');
        $this->assertNotFalse($notice);
        $this->assertTrue(strpos($html, 'login-card-body') < $notice && $notice < strpos($html, 'name="email"'));
    }

    public function testLoginPageWithoutNotice()
    {
        UserFactory::create()->admin();
        $this->get('admin/login')->assertDontSee('demo-credentials', false);
    }

    public function testWorkbenchDoesNotShowACredentialsNotice()
    {
        $this->app->register(WorkbenchServiceProvider::class);
        UserFactory::create()->admin();
        $this->get('admin/login')->assertDontSee('demo-credentials', false);
    }

    public function testWorkbenchPrefillsTheLoginForm()
    {
        $this->app->register(WorkbenchServiceProvider::class);
        UserFactory::create()->admin();
        $html = $this->get('admin/login')->getContent();
        $script = strpos($html, 'demo-prefill');
        $this->assertNotFalse($script);
        $this->assertTrue(strpos($html, '</form>') < $script);
        $this->assertStringContainsString(json_encode(['email' => DatabaseSeeder::EMAIL, 'password' => DatabaseSeeder::PASSWORD]), $html);
    }
}
