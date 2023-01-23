<?php

namespace Sebastienheyd\Boilerplate\Tests\Navbar;

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
        $this->expectException(\InvalidArgumentException::class);
        $repository->registerItem('badview');
    }

    public function testNavbarRepositoryBadModel()
    {
        $repository = new NavbarItemsRepository();
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Item is not an array or a string');
        $repository->registerItem($repository);
    }

    public function testNavbarRepositoryBadArray()
    {
        $repository = new NavbarItemsRepository();
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Registered item is not an instance of View');
        $repository->registerItem([$repository]);
    }

    public function testNavbarRepository()
    {
        $repository = new NavbarItemsRepository();
        $repository->registerItem('boilerplate::layout.header.darkmode');
        $repository->registerItem([
            'boilerplate::layout.header.darkmode',
            'boilerplate::layout.header.fullscreen',
        ], 'right');

        $itemsLeft = $repository->getItems('left');
        $itemsRight = $repository->getItems('right');

        $this->assertNotEmpty($itemsLeft);
        $this->assertNotEmpty($itemsRight);
    }
}
