<?php

namespace Sebastienheyd\Boilerplate\Tests\Dashboard;

use Sebastienheyd\Boilerplate\Tests\factories\UserFactory;
use Sebastienheyd\Boilerplate\Tests\TestCase;

class DashboardTest extends TestCase
{
    public function testAutoRegisterWidget()
    {
        $this->artisan('boilerplate:widget', ['name' => 'test widget'])
            ->expectsConfirmation('Generate test-widget widget?', 'yes')
            ->assertSuccessful();
    }

    public function testDashboardWidgetsRegistration()
    {
        UserFactory::create()->admin(true);

        app('boilerplate.dashboard.widgets')->load(app_path('Dashboard'))->registerWidget(
            self::class,
        );

        $widgets = app('boilerplate.dashboard.widgets')->getWidgets();
        $this->assertEquals(['current-user', 'users-number', 'latest-errors', 'test-widget'], array_keys($widgets));
    }

    public function testDashboardWidgetSet()
    {
        UserFactory::create()->admin(true);

        $widgets = app('boilerplate.dashboard.widgets')->getWidgets();
        $widget = $widgets['users-number']->set('bad')->set('test', 'value');
        $this->assertEquals(['test' => 'value'], $widget->getSettings());

        config(['boilerplate.dashboard.widgets' => []]);
        $this->assertEquals(['test' => 'value'], $widget->getSettings());

        $this->assertNull($widget->fake);
    }

    public function testAuthorizeNoView()
    {
        UserFactory::create()->admin(true);
        app('boilerplate.dashboard.widgets')->registerWidget(FakeWidget::class);

        $widgets = app('boilerplate.dashboard.widgets')->getWidgets();

        $this->assertTrue($widgets['fake-widget']->isAuthorized() === false);
    }
}
