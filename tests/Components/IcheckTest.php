<?php

namespace Sebastienheyd\Boilerplate\Tests\Components;

class IcheckTest extends TestComponent
{
    public function testIcheckComponent()
    {
        $expected = <<<'HTML'
<div class="form-group">
    <div class="icheck-primary">
        <input type="checkbox" id="test" name="test" autocomplete="off">
        <label for="test" class="font-weight-normal">Dashboard</label>
    </div>
</div>
HTML;

        $view = $this->blade('<x-boilerplate::icheck id="test" name="test" label="boilerplate::layout.dashboard" />');
        $view->assertSee($expected, false);

        $view = $this->blade('<x-boilerplate::icheck id="test" name="test" label="boilerplate::layout.dashboard" :checked="false" />');
        $view->assertSee($expected, false);
    }

    public function testIcheckComponentChecked()
    {
        $expected = <<<'HTML'
<div class="form-group">
    <div class="icheck-primary">
        <input type="checkbox" id="test" checked autocomplete="off">
        <label for="test" class="font-weight-normal"></label>
    </div>
</div>
HTML;

        $view = $this->blade('<x-boilerplate::icheck id="test" checked />');
        $view->assertSee($expected, false);

        $view = $this->blade('<x-boilerplate::icheck id="test" :checked="!isset($value)" />');
        $view->assertSee($expected, false);
    }

    public function testIcheckComponentExtraAttributes()
    {
        $expected = <<<'HTML'
<div class="form-group bg-red">
    <div class="icheck-primary" data-toggle="tooltip">
        <input type="checkbox" id="test" value="1" autocomplete="off">
        <label for="test" class="font-weight-normal"></label>
    </div>
</div>
HTML;

        $view = $this->blade('<x-boilerplate::icheck id="test" class="bg-red" data-toggle="tooltip" value="1"/>');
        $view->assertSee($expected, false);
    }
}
