<?php

namespace Sebastienheyd\Boilerplate\Tests\Components;

class MinifyTest extends TestComponent
{
    public function testMinify()
    {
        $expected = 'function test(){var var=!0}';

        if ($this->isLaravelEqualOrGreaterThan7()) {
            $view = $this->blade('<x-boilerplate::minify>function test() { var var = true; }</x-boilerplate::minify>');
            $view->assertSee($expected, false);
        }

        $view = $this->blade("@component('boilerplate::minify')function test() { var var = true; }@endcomponent");
        $view->assertSee($expected, false);
    }

    public function testMinifyDisabled()
    {
        config(['boilerplate.theme.minify' => false]);

        $expected = 'function test() { var var = true; }';

        if ($this->isLaravelEqualOrGreaterThan7()) {
            $view = $this->blade('<x-boilerplate::minify>function test() { var var = true; }</x-boilerplate::minify>');
            $view->assertSee($expected, false);
        }

        $view = $this->blade("@component('boilerplate::minify')function test() { var var = true; }@endcomponent");
        $view->assertSee($expected, false);

        config(['boilerplate.theme.minify' => true]);
    }
}