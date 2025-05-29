<?php

namespace Sebastienheyd\Boilerplate\Tests\Datatables;

use Sebastienheyd\Boilerplate\Datatables\Column;
use Sebastienheyd\Boilerplate\Datatables\Datatable;

class TestSumDatatable extends Datatable
{
    public $slug = 'test-sum';

    public function datasource()
    {
        return collect([
            ['id' => 1, 'name' => 'Item 1', 'price' => 100.50, 'quantity' => 5],
            ['id' => 2, 'name' => 'Item 2', 'price' => 75.25, 'quantity' => 3],
            ['id' => 3, 'name' => 'Item 3', 'price' => 200.00, 'quantity' => 2],
        ]);
    }

    public function columns(): array
    {
        return [
            Column::add('ID')
                ->data('id'),

            Column::add('Name')
                ->data('name'),

            Column::add('Price')
                ->data('price')
                ->sum(),

            Column::add('Quantity')
                ->data('quantity')
                ->sum(),
        ];
    }
}