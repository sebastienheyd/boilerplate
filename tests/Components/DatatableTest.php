<?php

namespace Sebastienheyd\Boilerplate\Tests\Components;

use Exception;
use Illuminate\View\ViewException;
use Sebastienheyd\Boilerplate\Tests\factories\UserFactory;

class DatatableTest extends TestComponent
{
    public function testDatatableNoName()
    {
        $this->expectException(ViewException::class);
        $this->blade('<x-boilerplate::datatable></x-boilerplate::datatable>');
    }

    public function testDatatableBadName()
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('DataTable class for "BadName" is not found');
        $this->blade('<x-boilerplate::datatable name="BadName"></x-boilerplate::datatable>');
    }

    public function testDatatableNoPermission()
    {
        UserFactory::create()->backendUser(true);

        $expected = <<<'HTML'
<code>
    &lt;x-boilerplate::datatable>
    You don't have permission to access the table "users"
</code>
HTML;

        $view = $this->blade('<x-boilerplate::datatable name="users"></x-boilerplate::datatable>');
        $view->assertSee($expected, false);
    }

    public function testDatatable()
    {
        UserFactory::create()->admin(true);

        $view = $this->blade('<x-boilerplate::datatable name="users"></x-boilerplate::datatable>');
        $this->assertTrue(preg_match('#<table class="table table-striped table-hover va-middle w-100" id="dt_users">#', $view) !== false);
    }
}
