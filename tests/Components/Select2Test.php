<?php

namespace Sebastienheyd\Boilerplate\Tests\Components;

class Select2Test extends TestComponent
{
    public function testSelect2ComponentNoName()
    {
        $expected = <<<'HTML'
<code>
    &lt;x-boilerplate::select2>
    The name attribute has not been set
</code>
HTML;

        if ($this->isLaravelEqualOrGreaterThan7) {
            $view = $this->blade('<x-boilerplate::select2 />');
            $this->assertEquals($expected, $view);
        }

        $view = $this->blade("@component('boilerplate::select2')@endcomponent()");
        $this->assertEquals($expected, $view);
    }

    public function testSelect2ComponentAttributes()
    {
        $expected = <<<'HTML'
<div class="form-group">
    <select id="test" class="form-control" data-test="test">
        <option></option>
        <option value="1">Value 1</option>
    </select>
</div>
    <script src=""></script>
    <script src=""></script>
    <script>$.extend(true,$.fn.select2.defaults,{language:'en',direction:'ltr'});</script>
    <script>
        $(function () {
            $('#test').select2({
                placeholder: '—',
                allowClear: false,
                language: "en",
                direction: "ltr",
                minimumInputLength: 0,
                width: '100%',
            });
        });
    </script>
HTML;

        if ($this->isLaravelEqualOrGreaterThan7) {
            $view = $this->blade('<x-boilerplate::select2 name="test" id="test" data-test="test"><option value="1">Value 1</option></x-boilerplate::select2>@stack("js")');
            $this->assertEquals($expected, $view);
        }

        $view = $this->blade("@component('boilerplate::select2', ['name' => 'test', 'id' => 'test', 'data-test' => 'test'])<option value=\"1\">Value 1</option>@endcomponent()@stack('js')");
        $this->assertEquals($expected, $view);
    }
}
