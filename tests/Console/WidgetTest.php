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

        $this->assertFileExists('app/Dashboard/TestOne.php');
        $this->assertFileExists('resources/views/dashboard/widgets/test-one.blade.php');
        $this->assertFileExists('resources/views/dashboard/widgets/test-oneEdit.blade.php');
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

        $this->assertFileExists('app/Dashboard/TestTwo.php');
        $this->assertFileExists('resources/views/dashboard/widgets/test-two.blade.php');
        $this->assertFileExists('resources/views/dashboard/widgets/test-twoEdit.blade.php');
    }

    public function testWidgetWithNameNoConfirmation()
    {
        $this->artisan('boilerplate:widget', ['name' => 'test three'])
            ->expectsConfirmation('Generate test-three widget?')
            ->assertSuccessful();

        $this->assertFileDoesNotExist('app/Dashboard/TestThree.php');
        $this->assertFileDoesNotExist('resources/views/dashboard/widgets/test-three.blade.php');
        $this->assertFileDoesNotExist('resources/views/dashboard/widgets/test-threeEdit.blade.php');
    }
}
