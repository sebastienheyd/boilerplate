<?php namespace Sebastienheyd\Boilerplate\Tests;

use Sebastienheyd\Boilerplate\BoilerplateServiceProvider;
use Orchestra\Testbench\TestCase as OrchestraTestCase;

abstract class TestCase extends OrchestraTestCase
{
    /**
     * Load package service provider
     *
     * @param  \Illuminate\Foundation\Application $app
     *
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [
            BoilerplateServiceProvider::class
        ];
    }
}
