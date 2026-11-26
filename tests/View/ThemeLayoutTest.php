<?php

namespace Sebastienheyd\Boilerplate\Tests\View;

use Illuminate\Support\Facades\View;
use Sebastienheyd\Boilerplate\Tests\factories\UserFactory;
use Sebastienheyd\Boilerplate\Tests\TestCase;

class ThemeLayoutTest extends TestCase
{
    public function testLoginPageModern()
    {
        config(['boilerplate.theme.style' => 'modern', 'boilerplate.theme.palette' => 'green']);
        UserFactory::create()->admin();
        $html = $this->get('admin/login')->getContent();
        $this->assertStringContainsString('themes/modern.min.css', $html);
        $this->assertMatchesRegularExpression('/<body class="[^"]*theme-modern palette-green/', $html);
    }

    public function testLoginPageClassic()
    {
        config(['boilerplate.theme.style' => 'classic']);
        UserFactory::create()->admin();
        $html = $this->get('admin/login')->getContent();
        $this->assertStringNotContainsString('modern.min.css', $html);
        $this->assertStringNotContainsString('theme-modern', $html);
        $this->assertStringContainsString('<body class="hold-transition login-page">', $html);
    }

    public function testLoginDarkModeUsesMatches()
    {
        UserFactory::create()->admin();
        $this->assertStringContainsString(
            'matchMedia("(prefers-color-scheme: dark)").matches',
            $this->get('admin/login')->getContent()
        );
    }

    public function testBackendModernAndStylesheetOrder()
    {
        config(['boilerplate.theme.style' => 'modern', 'boilerplate.theme.palette' => 'purple']);
        View::composer('boilerplate::layout.index', function () {
            View::startPush('css', '<link rel="stylesheet" href="/css/app-override.css">');
        });
        UserFactory::create()->admin(true);
        $html = $this->get('admin')->getContent();
        $this->assertMatchesRegularExpression('/<body class="[^"]*theme-modern palette-purple/', $html);
        $adminlte = strpos($html, 'adminlte.min.css');
        $modern = strpos($html, 'themes/modern.min.css');
        $override = strpos($html, 'app-override.css');
        $this->assertNotFalse($modern);
        $this->assertNotFalse($override);
        $this->assertTrue($adminlte < $modern && $modern < $override);
    }

    public function testBackendClassic()
    {
        config(['boilerplate.theme.style' => 'classic']);
        UserFactory::create()->admin(true);
        $html = $this->get('admin')->getContent();
        $this->assertStringNotContainsString('theme-modern', $html);
        $this->assertStringNotContainsString('modern.min.css', $html);
    }
}
