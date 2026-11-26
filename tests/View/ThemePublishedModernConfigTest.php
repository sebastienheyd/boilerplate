<?php

namespace Sebastienheyd\Boilerplate\Tests\View;

use Sebastienheyd\Boilerplate\Tests\TestCase;
use Sebastienheyd\Boilerplate\View\Theme;

class ThemePublishedModernConfigTest extends TestCase
{
    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();

        // Simulates a theme config published by the application, restored by tearDownAfterClass()
        $dir = self::$core_path.'/config/boilerplate';
        @mkdir($dir, 0755, true);
        file_put_contents($dir.'/theme.php', '<?php return '.var_export(['style' => 'modern', 'palette' => 'blue'], true).';');
    }

    public function testPublishedModernConfigIsKept()
    {
        $this->assertSame('modern', config('boilerplate.theme.style'));
        $this->assertSame('theme-modern palette-blue', Theme::bodyClasses());
    }
}
