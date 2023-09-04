<?php

namespace Sebastienheyd\Boilerplate\Tests\Console;

use Illuminate\Support\Facades\Schema;
use Sebastienheyd\Boilerplate\Tests\TestCase;

class DatatableTest extends TestCase
{
    public function testDatatable()
    {
        $dt = app('boilerplate.datatables')->load(app_path('Datatables'))->getDatatable('test');
        $this->assertFalse($dt);

        $this->artisan('boilerplate:datatable')
            ->expectsQuestion('Name of the DataTable component to create (E.g., <comment>users</comment>)', '')
            ->expectsOutput('Answer cannot be empty')
            ->expectsQuestion('Name of the DataTable component to create (E.g., <comment>users</comment>)', 'test')
            ->expectsConfirmation('Use a model as the data source?', 'no')
            ->expectsOutput('Datatable component generated with success : '.app_path('Datatables/TestDatatable.php'))
            ->assertSuccessful();

        $this->assertFileExists('app/Datatables/TestDatatable.php');

        $dt = app('boilerplate.datatables')->load(app_path('Datatables'))->getDatatable('test');
        $this->assertTrue($dt->slug === 'test');
    }

    public function testDatatableFileAlreadyExists()
    {
        $this->artisan('boilerplate:datatable')
            ->expectsQuestion('Name of the DataTable component to create (E.g., <comment>users</comment>)', 'test')
            ->expectsConfirmation('Use a model as the data source?', 'no')
            ->expectsConfirmation('File <comment>'.app_path('Datatables/TestDatatable.php').'</comment> already exists, overwrite?', 'no')
            ->assertSuccessful();

        $this->artisan('boilerplate:datatable')
            ->expectsQuestion('Name of the DataTable component to create (E.g., <comment>users</comment>)', 'test')
            ->expectsConfirmation('Use a model as the data source?', 'no')
            ->expectsConfirmation('File <comment>'.app_path('Datatables/TestDatatable.php').'</comment> already exists, overwrite?', 'yes')
            ->expectsOutput('Datatable component generated with success : '.app_path('Datatables/TestDatatable.php'))
            ->assertSuccessful();
    }

    public function testDatatableModel()
    {
        Schema::drop('users');

        $this->artisan('boilerplate:datatable')
            ->expectsQuestion('Name of the DataTable component to create (E.g., <comment>users</comment>)', 'users')
            ->expectsConfirmation('Use a model as the data source?', 'yes')
            ->expectsQuestion('Enter the model to use (E.g., <comment>App\Models\User</comment>)', 'FakeModel')
            ->expectsOutput('Class FakeModel does not exists')
            ->expectsQuestion('Enter the model to use (E.g., <comment>App\Models\User</comment>)', 'Sebastienheyd\\Boilerplate\\Models\\User')
            ->expectsOutput('Model structure is not accessible in the database')
            ->assertFailed();

        $this->artisan('boilerplate:datatable', ['--nodb' => true])
            ->expectsQuestion('Name of the DataTable component to create (E.g., <comment>users</comment>)', 'users')
            ->expectsConfirmation('Use a model as the data source?', 'yes')
            ->expectsQuestion('Enter the model to use (E.g., <comment>App\Models\User</comment>)', 'Sebastienheyd\\Boilerplate\\Models\\User')
            ->expectsOutput('Datatable component generated with success : '.app_path('Datatables/UsersDatatable.php'))
            ->assertSuccessful();

        $this->assertFileExists('app/Datatables/UsersDatatable.php');
    }
}
