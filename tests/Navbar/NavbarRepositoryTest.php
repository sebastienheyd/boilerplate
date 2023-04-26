<?php

namespace Sebastienheyd\Boilerplate\Tests\Navbar;

use Illuminate\View\View;
use Sebastienheyd\Boilerplate\Navbar\NavbarItemsRepository;
use Sebastienheyd\Boilerplate\Tests\TestCase;

class NavbarRepositoryTest extends TestCase
{
    public function testNavbarRepositoryBadSide()
    {
        $repository = new NavbarItemsRepository();
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Side is not allowed');
        $repository->registerItem('boilerplate::layout.header.darkmode', 'badside');
    }

    public function testNavbarRepositoryBadView()
    {
        $itemsLeft = config('boilerplate.theme.navbar.left', []);
        $itemsRight = config('boilerplate.theme.navbar.right', []);

        $this->assertEmpty($itemsLeft);
        $this->assertEmpty($itemsRight);

        $repository = new NavbarItemsRepository();
        $repository->registerItem('badview');

        $this->expectException(\InvalidArgumentException::class);
        $repository->getItems();
    }

    public function testNavbarRepository()
    {
        $repository = new NavbarItemsRepository();
        $repository->registerItem('boilerplate::layout.header.darkmode');
        $repository->registerItem('boilerplate::layout.header.fullscreen');
        $repository->registerItem([
            'boilerplate::layout.header.darkmode',
            'boilerplate::layout.header.fullscreen',
        ], 'right');

        $itemsLeft = $repository->getItems('left');
        $itemsRight = $repository->getItems('right');

        $this->assertNotEmpty($itemsLeft);
        $this->assertNotEmpty($itemsRight);
        $this->assertTrue($itemsRight[0] instanceof View);
        $this->assertTrue($itemsRight[1] instanceof View);
        $this->assertTrue($itemsLeft[0] instanceof View);
        $this->assertTrue($itemsLeft[1] instanceof View);
    }
}
