<?php

namespace Sebastienheyd\Boilerplate\Tests\Console;

use Sebastienheyd\Boilerplate\Tests\TestCase;

class WidgetTest extends TestCase
{
    public function testWidgetNoName()
    {
        $this->artisan('boilerplate:widget')
            ->expectsQuestion('Name of the widget to create (will be used as slug)', 'test one')
            ->expectsConfirmation('Generate test-one widget?', 'yes')
            ->assertSuccessful();

        $this->assertFileExistsTestBench('app/Dashboard/TestOne.php');
        $this->assertFileExistsTestBench('resources/views/dashboard/widgets/test-one.blade.php');
        $this->assertFileExistsTestBench('resources/views/dashboard/widgets/test-oneEdit.blade.php');
    }

    public function testWidgetAlreadyExists()
    {
        $this->artisan('boilerplate:widget', ['name' => 'test one'])
            ->expectsOutput('Widget test-one already exists')
            ->assertFailed();
    }

    public function testWidgetWithName()
    {
        $this->artisan('boilerplate:widget', ['name' => 'test two'])
            ->expectsConfirmation('Generate test-two widget?', 'yes')
            ->assertSuccessful();

        $this->assertFileExistsTestBench('app/Dashboard/TestTwo.php');
        $this->assertFileExistsTestBench('resources/views/dashboard/widgets/test-two.blade.php');
        $this->assertFileExistsTestBench('resources/views/dashboard/widgets/test-twoEdit.blade.php');
    }

    public function testWidgetWithNameNoConfirmation()
    {
        $this->artisan('boilerplate:widget', ['name' => 'test three'])
            ->expectsConfirmation('Generate test-three widget?')
            ->assertSuccessful();

        $this->assertFileDoesNotExistTestBench('app/Dashboard/TestThree.php');
        $this->assertFileDoesNotExistTestBench('resources/views/dashboard/widgets/test-three.blade.php');
        $this->assertFileDoesNotExistTestBench('resources/views/dashboard/widgets/test-threeEdit.blade.php');
    }
}
