<?php

namespace Sebastienheyd\Boilerplate\Tests\Datatables;

use Sebastienheyd\Boilerplate\Tests\TestCase;

class SumTest extends TestCase
{
    public function testColumnSumMethod()
    {
        $datatable = new TestSumDatatable();
        $columns = $datatable->getColumns();

        // Vérifier que les colonnes Price et Quantity ont la propriété sum activée
        $this->assertTrue($columns[2]->sum); // Price column
        $this->assertTrue($columns[3]->sum); // Quantity column
        $this->assertFalse($columns[0]->sum); // ID column
        $this->assertFalse($columns[1]->sum); // Name column
    }

    public function testGetSumColumns()
    {
        $datatable = new TestSumDatatable();
        $sumColumns = $datatable->getSumColumns();

        // Vérifier que les index des colonnes avec sum sont corrects
        $this->assertEquals([2, 3], $sumColumns);
    }

    public function testFooterCallbackGeneration()
    {
        $datatable = new TestSumDatatable();
        $footerCallback = $datatable->footerCallback;

        // Vérifier que le footerCallback est généré
        $this->assertNotNull($footerCallback);
        $this->assertStringContainsString('function (row, data, start, end, display)', $footerCallback);
        $this->assertStringContainsString('[2,3]', $footerCallback); // Les colonnes avec sum
    }

    public function testFooterCallbackHandlesFormattedData()
    {
        $datatable = new TestSumDatatable();
        $footerCallback = $datatable->footerCallback;

        // Vérifier que le JavaScript gère le contenu HTML
        $this->assertStringContainsString('tempDiv.innerHTML = b;', $footerCallback);
        $this->assertStringContainsString('tempDiv.textContent', $footerCallback);
        $this->assertStringContainsString("val === '.' ? '0' : val", $footerCallback);
    }
}
