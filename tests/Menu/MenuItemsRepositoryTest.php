<?php

namespace Sebastienheyd\Boilerplate\Tests\Menu;

use Sebastienheyd\Boilerplate\Menu\MenuItemsRepository;
use Sebastienheyd\Boilerplate\Tests\TestCase;

class MenuItemsRepositoryTest extends TestCase
{
    public function testRegisterMenuItem()
    {
        $repository = new MenuItemsRepository();
        $repository->registerMenuItem('test1');
        $repository->registerMenuItem(['test2', 'test3']);

        $items = $repository->getMenuItems();
        $this->assertTrue(in_array('test1', $items) && in_array('test2', $items));

        $repository->unregisterMenuItem('test1');
        $items = $repository->getMenuItems();
        $this->assertNotTrue(in_array('test1', $items));
    }
}
