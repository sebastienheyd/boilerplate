<?php

namespace Sebastienheyd\Boilerplate\Tests\Datatables;

use Sebastienheyd\Boilerplate\Datatables\Button;
use Sebastienheyd\Boilerplate\Tests\TestCase;

class ButtonTest extends TestCase
{
    public function testTooltipMethod()
    {
        $button = Button::add('Test Button')
            ->link('/test')
            ->tooltip('This is a tooltip')
            ->make();

        $this->assertStringContainsString('title="This is a tooltip"', $button);
    }

    public function testTooltipNotAddedWhenEmpty()
    {
        $button = Button::add('Test Button')
            ->link('/test')
            ->make();

        $this->assertStringNotContainsString('title=', $button);
    }

    public function testTooltipMethodChaining()
    {
        $button = Button::add('Test')
            ->link('/test')
            ->tooltip('Tooltip text')
            ->color('primary')
            ->icon('star')
            ->make();

        $this->assertStringContainsString('title="Tooltip text"', $button);
        $this->assertStringContainsString('btn-primary', $button);
        $this->assertStringContainsString('fa-star', $button);
    }

    public function testButtonHtmlStructure()
    {
        $button = Button::add('Click me')
            ->link('/action')
            ->tooltip('Button tooltip')
            ->color('success')
            ->make();

        $this->assertMatchesRegularExpression('/<a href="\/action" data-toggle="tooltip" title="Button tooltip" class="btn btn-sm btn-success/', $button);
    }

    public function testCustomButtonWithRoute()
    {
        // Define a test route
        $this->app['router']->get('/test/{id}', function () {
            return 'test';
        })->name('test.route');

        $button = Button::custom(
            'test.route',
            ['id' => 1],
            'star',
            'Custom tooltip',
            'success'
        );

        $this->assertStringContainsString('title="Custom tooltip"', $button);
        $this->assertStringContainsString('btn-success', $button);
        $this->assertStringContainsString('fa-star', $button);
        $this->assertStringContainsString('/test/1', $button);
    }

    public function testCustomButtonWithAttributes()
    {
        $this->app['router']->get('/test', function () {
            return 'test';
        })->name('test.route2');

        $button = Button::custom(
            'test.route2',
            [],
            'heart',
            'Custom tooltip',
            'primary',
            ['data-action' => 'custom-action', 'data-id' => '123']
        );

        $this->assertStringContainsString('data-action="custom-action"', $button);
        $this->assertStringContainsString('data-id="123"', $button);
        $this->assertStringContainsString('btn-primary', $button);
        $this->assertStringContainsString('fa-heart', $button);
    }

    public function testCustomButtonWithDefaults()
    {
        $this->app['router']->get('/default', function () {
            return 'test';
        })->name('test.default');

        $button = Button::custom('test.default');

        $this->assertStringNotContainsString('title=', $button);
        $this->assertStringContainsString('btn-default', $button);
        $this->assertStringNotContainsString('fa-', $button); // No icon by default
    }

    public function testCustomButtonArgumentOrder()
    {
        // Test that $icon comes before $tooltip in the method signature
        $this->app['router']->get('/order', function () {
            return 'test';
        })->name('test.order');

        $button = Button::custom(
            'test.order',
            [],
            'cog',      // $icon (3rd parameter)
            'Tooltip',  // $tooltip (4th parameter)
            'warning'   // $color (5th parameter)
        );

        $this->assertStringContainsString('fa-cog', $button);
        $this->assertStringContainsString('title="Tooltip"', $button);
        $this->assertStringContainsString('btn-warning', $button);
    }
}
