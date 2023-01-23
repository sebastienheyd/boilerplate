<?php

namespace Sebastienheyd\Boilerplate\Tests\Components;

use Exception;
use Illuminate\View\ViewException;
use Sebastienheyd\Boilerplate\Tests\factories\UserFactory;

class DatatableTest extends TestComponent
{
    public function testDatatableNoName()
    {
        if ($this->minLaravelVersion('7.0')) {
            $this->expectException(ViewException::class);
            $this->blade('<x-boilerplate::datatable></x-boilerplate::datatable>');
        }

        $this->expectException(ViewException::class);
        $this->blade("@component('boilerplate::datatable')@endcomponent");
    }

    public function testDatatableBadName()
    {
        if ($this->minLaravelVersion('7.0')) {
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

        if ($this->minLaravelVersion('7.0')) {
            $view = $this->blade('<x-boilerplate::datatable name="users"></x-boilerplate::datatable>');
            $view->assertSee($expected, false);
        }

        $view = $this->blade("@component('boilerplate::datatable', ['name' => 'users'])@endcomponent");
        $view->assertSee($expected, false);
    }

    public function testDatatable()
    {
        UserFactory::create()->admin(true);

        if ($this->minLaravelVersion('7.0')) {
            $view = $this->blade('<x-boilerplate::datatable name="users"></x-boilerplate::datatable>');
            $this->assertTrue(preg_match('#<table class="table table-striped table-hover va-middle w-100" id="dt_users">#', $view) !== false);
        }

        $view = $this->blade("@component('boilerplate::datatable', ['name' => 'users'])@endcomponent");
        $this->assertTrue(preg_match('#<table class="table table-striped table-hover va-middle w-100" id="dt_users">#', $view) !== false);
    }
}
