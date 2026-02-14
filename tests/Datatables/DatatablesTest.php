<?php

namespace Sebastienheyd\Boilerplate\Tests\Datatables;

use Sebastienheyd\Boilerplate\Datatables\Column;
use Sebastienheyd\Boilerplate\Tests\factories\UserFactory;
use Sebastienheyd\Boilerplate\Tests\TestCase;

class DatatablesTest extends TestCase
{
    public function testColumnVisibleTrue()
    {
        $column = Column::add('Name')->data('name')->visible(true);
        $result = $column->get();
        $this->assertEquals('{data:"name"}', $result);
    }

    public function testColumnVisibleFalse()
    {
        $column = Column::add('Name')->data('name')->visible(false);
        $result = $column->get();
        $this->assertEquals('{data:"name",visible:false}', $result);
    }

    public function testColumnHidden()
    {
        $column = Column::add('Name')->data('name')->hidden();
        $result = $column->get();
        $this->assertEquals('{data:"name",visible:false}', $result);
    }

    public function testColumnVisibleRemovesHidden()
    {
        $column = Column::add('Name')->data('name')->hidden()->visible(true);
        $result = $column->get();
        $this->assertEquals('{data:"name"}', $result);
    }

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
