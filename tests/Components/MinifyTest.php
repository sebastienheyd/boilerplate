<?php

namespace Sebastienheyd\Boilerplate\Tests\Components;

class MinifyTest extends TestComponent
{
    public function testMinify()
    {
        $expected = 'function test(){var var=!0}';

        if ($this->isLaravelEqualOrGreaterThan7) {
            $view = $this->blade('<x-boilerplate::minify>function test() { var var = true; }</x-boilerplate::minify>');
            $this->assertEquals($expected, $view);
        }

        $view = $this->blade("@component('boilerplate::minify')function test() { var var = true; }@endcomponent");
        $this->assertEquals($expected, $view);
    }

    public function testMinifyDisabled()
    {
        config(['boilerplate.theme.minify' => false]);

        $expected = 'function test() { var var = true; }';

        if ($this->isLaravelEqualOrGreaterThan7) {
            $view = $this->blade('<x-boilerplate::minify>function test() { var var = true; }</x-boilerplate::minify>');
            $this->assertEquals($expected, $view);
        }

        $view = $this->blade("@component('boilerplate::minify')function test() { var var = true; }@endcomponent");
        $this->assertEquals($expected, $view);

        config(['boilerplate.theme.minify' => true]);
    }
}