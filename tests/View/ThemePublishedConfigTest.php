<?php

namespace Sebastienheyd\Boilerplate\Tests\View;

use Sebastienheyd\Boilerplate\Tests\TestCase;
use Sebastienheyd\Boilerplate\View\Theme;

class ThemePublishedConfigTest extends TestCase
{
    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();

        // Simulates a theme config published before the modern style existed, restored by tearDownAfterClass()
        $dir = self::$core_path.'/config/boilerplate';
        @mkdir($dir, 0755, true);
        file_put_contents($dir.'/theme.php', '<?php return '.var_export(['navbar' => ['bg' => 'white']], true).';');
    }

    public function testPublishedConfigWithoutStyleStaysClassic()
    {
        $this->assertSame('classic', config('boilerplate.theme.style'));
        $this->assertSame('', Theme::bodyClasses());
    }
}
