<?php

namespace Sebastienheyd\Boilerplate\Tests\Components;

class IcheckTest extends TestComponent
{
    public function testIcheckComponent()
    {
$expected = <<<HTML
<div class="form-group">
    <div class="icheck-primary d-inline">
        <input type="checkbox" id="test" name="test">
        <label for="test" class="font-weight-normal">Dashboard</label>
    </div>
</div>
HTML;

        if ($this->isLaravelEqualOrGreaterThan7) {
            $view = $this->blade('<x-boilerplate::icheck id="test" name="test" label="boilerplate::layout.dashboard" />');
            $this->assertEquals($expected, $view);
        }

        $view = $this->blade("@component('boilerplate::icheck', ['name' => 'test', 'id' => 'test', 'label' => 'boilerplate::layout.dashboard']) @endcomponent");
        $this->assertEquals($expected, $view);
    }
}
