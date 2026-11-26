<?php

namespace Sebastienheyd\Boilerplate\Tests\View;

use Sebastienheyd\Boilerplate\Tests\TestCase;
use Sebastienheyd\Boilerplate\View\Theme;

class ThemeTest extends TestCase
{
    public function testStyleFallsBackToClassic()
    {
        foreach ([null, 'MODERN', 'dark', ''] as $value) {
            config(['boilerplate.theme.style' => $value]);
            $this->assertSame('classic', Theme::style());
            $this->assertFalse(Theme::isModern());
            $this->assertSame('', Theme::bodyClasses());
        }
    }

    public function testPaletteFallsBackToOrange()
    {
        config(['boilerplate.theme.style' => 'modern', 'boilerplate.theme.palette' => 'pink']);
        $this->assertSame('orange', Theme::palette());
        $this->assertSame('theme-modern palette-orange', Theme::bodyClasses());
    }

    public function testModernWithPalette()
    {
        config(['boilerplate.theme.style' => 'modern', 'boilerplate.theme.palette' => 'teal']);
        $this->assertTrue(Theme::isModern());
        $this->assertSame('theme-modern palette-teal', Theme::bodyClasses());
    }

    public function testStyleForPublishedConfig()
    {
        $this->assertNull(Theme::styleForPublishedConfig(null));
        $this->assertSame('classic', Theme::styleForPublishedConfig(['navbar' => []]));
        $this->assertNull(Theme::styleForPublishedConfig(['style' => 'modern']));
        $this->assertNull(Theme::styleForPublishedConfig(['style' => 'classic']));
    }

    public function testPackageDefaultIsModern()
    {
        $this->assertSame('modern', config('boilerplate.theme.style'));
        $this->assertSame('orange', config('boilerplate.theme.palette'));
    }
}
