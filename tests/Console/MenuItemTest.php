<?php

namespace Sebastienheyd\Boilerplate\Tests\Console;

use Sebastienheyd\Boilerplate\Tests\TestCase;

class MenuItemTest extends TestCase
{
    public function testMenuItem()
    {
        $this->artisan('boilerplate:menuitem')
            ->expectsQuestion('Name of the menu item to create', 'test')
            ->assertSuccessful();
        $this->assertFileExistsTestBench('/app/Menu/Test.php');

        $this->artisan('boilerplate:menuitem', ['name' => 'test'])
            ->expectsOutput('Menu item Test already exists')
            ->assertFailed();

        $this->artisan('boilerplate:menuitem', ['name' => 'menu'])->assertSuccessful();
        $this->assertFileExistsTestBench('/app/Menu/Menu.php');

        $this->artisan('boilerplate:menuitem', ['name' => 'submenu', '--submenu' => true])->assertSuccessful();
        $this->assertFileExistsTestBench('/app/Menu/Submenu.php');
    }
}
