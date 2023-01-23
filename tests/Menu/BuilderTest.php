<?php

namespace Sebastienheyd\Boilerplate\Tests\Menu;

use Sebastienheyd\Boilerplate\Menu\Builder;
use Sebastienheyd\Boilerplate\Tests\factories\UserFactory;
use Sebastienheyd\Boilerplate\Tests\TestCase;

class BuilderTest extends TestCase
{
    public function testBuilder()
    {
        UserFactory::create()->admin(true);

        $builder = new Builder('test', []);

        $item = $builder->add('test', ['id' => 'test', 'role' => 'admin']);
        $this->assertEquals('<i class="nav-icon fas fa-cube"></i><p>test</p>', $item->title);

        $item = $builder->addTo('test', 'test 2');
        $this->assertEquals('<i class="nav-icon far fa-circle"></i><p>test 2</p>', $item->title);

        $item = $builder->addTo('noid', 'test 3');
        $this->assertEquals('<i class="nav-icon fas fa-cube"></i><p>test 3</p>', $item->title);
    }
}
