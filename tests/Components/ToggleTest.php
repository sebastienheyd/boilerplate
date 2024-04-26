<?php

namespace Sebastienheyd\Boilerplate\Tests\Components;

class ToggleTest extends TestComponent
{
    public function testToggleComponent()
    {
        $expected = <<<'HTML'
<div class="form-group">
    <div class="custom-control custom-switch custom-switch-off-light custom-switch-on-primary">
        <input type="checkbox" class="custom-control-input" id="test" name="test">
        <label class="custom-control-label font-weight-normal" for="test">Dashboard</label>
    </div>
</div>
HTML;

        $view = $this->blade('<x-boilerplate::toggle id="test" name="test" label="boilerplate::layout.dashboard" />');
        $view->assertSee($expected, false);

        $view = $this->blade('<x-boilerplate::toggle id="test" name="test" label="boilerplate::layout.dashboard" :checked="false" />');
        $view->assertSee($expected, false);
    }

    public function testToggleComponentChecked()
    {
        $expected = <<<'HTML'
<div class="form-group">
    <div class="custom-control custom-switch custom-switch-off-light custom-switch-on-primary">
        <input type="checkbox" class="custom-control-input" id="test" checked>
        <label class="custom-control-label font-weight-normal" for="test"></label>
    </div>
</div>
HTML;

        $view = $this->blade('<x-boilerplate::toggle id="test" checked />');
        $view->assertSee($expected, false);

        $view = $this->blade('<x-boilerplate::toggle id="test" :checked="!isset($value)" />');
        $view->assertSee($expected, false);
    }

    public function testToggleComponentExtraAttributes()
    {
        $expected = <<<'HTML'
<div class="form-group bg-red">
    <div class="custom-control custom-switch custom-switch-off-light custom-switch-on-primary" data-toggle="tooltip">
        <input type="radio" class="custom-control-input" id="test" value="1">
        <label class="custom-control-label font-weight-normal" for="test"></label>
    </div>
</div>
HTML;

        $view = $this->blade('<x-boilerplate::toggle type="radio" id="test" value="1" class="bg-red" data-toggle="tooltip" />');
        $view->assertSee($expected, false);
    }
}
