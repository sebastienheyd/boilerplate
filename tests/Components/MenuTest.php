<?php

namespace Sebastienheyd\Boilerplate\Tests\Components;

use Sebastienheyd\Boilerplate\Tests\factories\UserFactory;
use Sebastienheyd\Boilerplate\Tests\TestCase;

class MenuTest extends TestComponent
{
    public function testMenu()
    {
        $user = UserFactory::create()->admin();

        $this->artisan('boilerplate:menuitem')
            ->expectsQuestion('Name of the menu item to create', 'test')
            ->assertSuccessful();

        $this->assertFileExists('/app/Menu/Test.php');
        require_once TestCase::$testbench_path.'/app/Menu/Test.php';

        $expected = '<aside class="main-sidebar sidebar-dark-blue elevation-4">
    <a href="http://localhost/admin" class="brand-link d-flex bg-gray-dark">
        <span class="brand-logo bg-blue elevation-2">
            <i class="fa fa-cubes"></i>
        </span>
        <span class="brand-text text-truncate pr-2" title="BOilerplate"><strong>BO</strong>ilerplate</span>
    </a>
    <div class="sidebar">
                    <div class="user-panel d-flex align-items-center">
                <div class="image">
                    <img src="https://ui-avatars.com/api/?background=F0F0F0&amp;color=333&amp;size=170&amp;name='.$user->first_name.'+'.$user->last_name.'" class="avatar-img img-circle elevation-2" alt="'.$user->first_name.' '.$user->last_name.'">
                </div>
                <div class="info">
                    <a href="http://localhost/admin/userprofile" class="d-flex flex-wrap">
                        <span class="mr-1">'.$user->first_name.'</span>
                        <span class="text-truncate text-uppercase font-weight-bolder">'.$user->last_name.'</span>
                    </a>
                </div>
            </div>
                <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column nav-child-indent" data-widget="treeview" data-accordion="false" role="menu"><li class="nav-item"><a class="nav-link" href="http://localhost/admin"><i class="nav-icon fas fa-home"></i><p>Dashboard</p></a></li><li order="100" class="nav-item"><a class="nav-link" href="http://localhost/admin"><i class="nav-icon fas fa-square"></i><p>test</p></a></li><li order="1000" class="nav-item"><a class="nav-link"><i class="nav-icon fas fa-users"></i><p>Users</p><i class="fa fa-angle-left right"></i><i class="fa fa-angle-left right"></i><i class="fa fa-angle-left right"></i><i class="fa fa-angle-left right"></i></a><ul class="nav nav-treeview"><li order="1001" class="nav-item"><a class="nav-link" href="http://localhost/admin/userprofile"><i class="nav-icon far fa-circle"></i><p>My profile</p></a></li><li order="1002" class="nav-item"><a class="nav-link" href="http://localhost/admin/users/create"><i class="nav-icon far fa-circle"></i><p>Add a user</p></a></li><li order="1003" class="nav-item"><a class="nav-link" href="http://localhost/admin/users"><i class="nav-icon far fa-circle"></i><p>User list</p></a></li><li order="1004" class="nav-item"><a class="nav-link" href="http://localhost/admin/roles"><i class="nav-icon far fa-circle"></i><p>Roles</p></a></li></ul></li><li order="1100" class="nav-item"><a class="nav-link"><i class="nav-icon fas fa-list"></i><p>Logs</p><i class="fa fa-angle-left right"></i><i class="fa fa-angle-left right"></i></a><ul class="nav nav-treeview"><li class="nav-item"><a class="nav-link" href="http://localhost/admin/logs"><i class="nav-icon far fa-circle"></i><p>Statistics</p></a></li><li class="nav-item"><a class="nav-link" href="http://localhost/admin/logs/list"><i class="nav-icon far fa-circle"></i><p>Reports</p></a></li></ul></li></ul>
        </nav>
    </div>
</aside>';

        $view = $this->actingAs($user)->blade('@include("boilerplate::layout/mainsidebar")');
        $view->assertSee($expected, false);

        unlink(TestCase::$testbench_path.'/app/Menu/Test.php');
        $this->assertFileDoesNotExist('/app/Menu/Test.php');
    }
}
