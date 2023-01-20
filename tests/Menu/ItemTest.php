<?php

namespace Sebastienheyd\Boilerplate\Tests\Menu;

use Sebastienheyd\Boilerplate\Menu\Builder;
use Sebastienheyd\Boilerplate\Tests\TestCase;
use Sebastienheyd\Boilerplate\Menu\Item;

class ItemTest extends TestCase
{
    public function testIcon()
    {
        $builder = new Builder('test', []);

        $item = new Item($builder, 'id', 'test', []);
        $item->icon('test.png');
        $this->assertEquals('<div class="nav-icon d-inline-block text-sm"><img src="test.png" class="img-fluid" style="max-height: 17px" /></div>test', $item->title);

        $item->icon('fas fa-times');
        $this->assertEquals('<i class="nav-icon fas fa-times"></i><div class="nav-icon d-inline-block text-sm"><img src="test.png" class="img-fluid" style="max-height: 17px" /></div>test', $item->title);
    }
}