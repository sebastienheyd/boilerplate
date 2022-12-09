<?php

namespace Sebastienheyd\Boilerplate\Tests\Datatables;

use Sebastienheyd\Boilerplate\Tests\factories\UserFactory;
use Sebastienheyd\Boilerplate\Tests\TestCase;

class DatatablesTest extends TestCase
{
    public function testDatatable()
    {
        UserFactory::create()->admin(true);
        UserFactory::create()->backendUser();
        UserFactory::create()->backendUser();

        $datatable = new TestDatatable();
        $datatable->setUp();

        $columns = $datatable->getColumns();

        $this->assertEquals('{searchable:false,orderable:false,data:"checkbox"}', $columns[0]->get());

        $dt = $datatable->make();
        $content = $dt->getOriginalContent();

        $this->assertEquals(3, $content['recordsTotal']);
    }
}