<?php

namespace Sebastienheyd\Boilerplate\Tests\Components;

use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\ViewException;
use Sebastienheyd\Boilerplate\database\factories\UserFactory;
use Sebastienheyd\Boilerplate\Models\Permission;
use Sebastienheyd\Boilerplate\Models\Role;
use Sebastienheyd\Boilerplate\Models\User;

class DatatableTest extends TestComponent
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->migrate();
    }

    public function testDatatableNoName()
    {
        if ($this->isLaravelEqualOrGreaterThan7) {
            $this->expectException(ViewException::class);
            $this->blade('<x-boilerplate::datatable></x-boilerplate::datatable>');
        }

        $this->expectException(ViewException::class);
        $this->blade("@component('boilerplate::datatable')@endcomponent");
    }

    public function testDatatableBadName()
    {
        if ($this->isLaravelEqualOrGreaterThan7) {
            $this->expectException(Exception::class);
            $this->expectExceptionMessage('DataTable class for "BadName" is not found');
            $this->blade('<x-boilerplate::datatable name="BadName"></x-boilerplate::datatable>');
        }

        $this->expectException(Exception::class);
        $this->expectExceptionMessage('DataTable class for "BadName" is not found');
        $this->blade("@component('boilerplate::datatable', ['name' => 'BadName'])@endcomponent");
    }

    public function testDatatableNoPermission()
    {
        $user = UserFactory::create()->backendUser(true);

        $expected = <<<'HTML'
<code>
    &lt;x-boilerplate::datatable>
    You don't have permission to access the table "users"
</code>
HTML;

        if ($this->isLaravelEqualOrGreaterThan7) {
            $view = $this->blade('<x-boilerplate::datatable name="users"></x-boilerplate::datatable>');
            $this->assertEquals($expected, $view);
        }

        $view = $this->blade("@component('boilerplate::datatable', ['name' => 'users'])@endcomponent");
        $this->assertEquals($expected, $view);
    }

    public function testDatatable()
    {
        UserFactory::create()->admin(true);

        if ($this->isLaravelEqualOrGreaterThan7) {
            $view = $this->blade('<x-boilerplate::datatable name="users"></x-boilerplate::datatable>');
            $this->assertTrue(preg_match('#<table class="table table-striped table-hover va-middle w-100" id="dt_users">#', $view) !== false);
        }

        $view = $this->blade("@component('boilerplate::datatable', ['name' => 'users'])@endcomponent");
        $this->assertTrue(preg_match('#<table class="table table-striped table-hover va-middle w-100" id="dt_users">#', $view) !== false);
    }
}