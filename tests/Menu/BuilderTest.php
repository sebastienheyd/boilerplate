<?php

namespace Sebastienheyd\Boilerplate\Tests\Menu;

use Sebastienheyd\Boilerplate\Menu\Builder;
use Sebastienheyd\Boilerplate\Tests\factories\UserFactory;
use Sebastienheyd\Boilerplate\Tests\TestCase;

class BuilderTest extends TestCase
{
    public function testBuilderWithPermission()
    {
        UserFactory::create()->admin(true);

        $builder = new Builder('test', []);
        $builder->add('test', ['id' => 'test', 'role' => 'admin']);
        $builder->addTo('test', 'test 2')->icon('times');
        $menu = '<ul><li id="test" class="nav-item has-treeview" url="#"><a class="nav-link"><i class="nav-icon fas fa-stop"></i><p>test</p><i class="fa fa-angle-left right"></i></a><ul><li class="nav-item"><a class="nav-link"><i class="nav-icon fas fa-times"></i><p>test 2</p></a></li></ul></li></ul>';
        $this->assertEquals($menu, $builder->asUl());
    }

    public function testBuilderWithNoPermission()
    {
        UserFactory::create()->user(true);

        $builder = new Builder('test', []);
        $builder->add('test', ['id' => 'test', 'role' => 'admin']);
        $builder->addTo('test', 'test 2')->icon('times');
        $this->assertEquals('<ul></ul>', $builder->asUl());
    }

    public function testBuilderSubitem()
    {
        UserFactory::create()->user(true);

        $builder = new Builder('test', []);
        $builder->add('test', ['id' => 'test']);
        $builder->addTo('test', 'test 2', ['icon' => 'home']);
        $menu = '<ul><li id="test" class="nav-item has-treeview" url="#"><a class="nav-link"><i class="nav-icon fas fa-stop"></i><p>test</p><i class="fa fa-angle-left right"></i></a><ul><li class="nav-item"><a class="nav-link"><i class="nav-icon fas fa-home"></i><p>test 2</p></a></li></ul></li></ul>';
        $this->assertEquals($menu, $builder->asUl());
    }

    public function testBuilderIcon()
    {
        UserFactory::create()->user(true);

        $builder = new Builder('test', []);
        $builder->add('test', ['id' => 'test']);
        $builder->addTo('test', 'test 2', ['icon' => 'fab fa-times']);
        $menu = '<ul><li id="test" class="nav-item has-treeview" url="#"><a class="nav-link"><i class="nav-icon fas fa-stop"></i><p>test</p><i class="fa fa-angle-left right"></i></a><ul><li class="nav-item"><a class="nav-link"><i class="nav-icon fab fa-times"></i><p>test 2</p></a></li></ul></li></ul>';
        $this->assertEquals($menu, $builder->asUl());
    }

    public function testBuilderSubitemImgIcon()
    {
        UserFactory::create()->user(true);

        $builder = new Builder('test', []);
        $builder->add('test', ['id' => 'test']);
        $builder->addTo('test', 'test 2')->icon('test.png');
        $menu = '<ul><li id="test" class="nav-item has-treeview" url="#"><a class="nav-link"><i class="nav-icon fas fa-stop"></i><p>test</p><i class="fa fa-angle-left right"></i></a><ul><li class="nav-item"><a class="nav-link"><div class="nav-icon d-inline-block text-sm"><img src="test.png" class="img-fluid" style="max-height: 17px" /></div><p>test 2</p></a></li></ul></li></ul>';
        $this->assertEquals($menu, $builder->asUl());
    }

    public function testBuilderSubitemNoParent()
    {
        UserFactory::create()->user(true);

        $builder = new Builder('test', []);
        $builder->addTo('fake', 'test');
        $this->assertEquals('<ul></ul>', $builder->asUl());
    }

    public function testBuilderSubitemBadParent()
    {
        UserFactory::create()->user(true);

        $builder = new Builder('test', []);
        $builder->add('test', ['id' => 'test']);
        $builder->addTo('noid', 'test 2')->icon('times');
        $menu = '<ul><li id="test" class="nav-item"><a class="nav-link"><i class="nav-icon fas fa-stop"></i><p>test</p></a></li></ul>';
        $this->assertEquals($menu, $builder->asUl());
    }
    
}
