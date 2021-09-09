<?php

namespace Sebastienheyd\Boilerplate\Tests;

use Collective\Html\HtmlServiceProvider;
use Orchestra\Testbench\TestCase as OrchestraTestCase;
use Sebastienheyd\Boilerplate\BoilerplateServiceProvider;

abstract class TestCase extends OrchestraTestCase
{
    /**
     * Load package service provider.
     *
     * @param  \Illuminate\Foundation\Application  $app
     *
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [
            HtmlServiceProvider::class,
            BoilerplateServiceProvider::class,
        ];
    }

    protected function getPackageAliases($app)
    {
        return [
            'Form' => 'Collective\Html\FormFacade',
        ];
    }
}
