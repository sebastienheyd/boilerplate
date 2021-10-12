<?php

namespace Sebastienheyd\Boilerplate\Tests\Components;

class CodemirrorTest extends TestComponent
{
    public function testCodeMirrorComponentNoName()
    {
        $expected = <<<'HTML'
<code>&lt;x-boilerplate::codemirror> The name attribute has not been set</code>
HTML;

        if ($this->isLaravelEqualOrGreaterThan7) {
            $view = $this->blade('<x-boilerplate::codemirror />');
            $this->assertEquals($expected, $view);
        }

        $view = $this->blade("@component('boilerplate::codemirror')@endcomponent()");
        $this->assertEquals($expected, $view);
    }

    public function testCodeMirrorName()
    {
        $expected = <<<'HTML'
<div class="form-group test" id="test">
    <label for="test">test</label>
    <textarea id="test" name="test" style="visibility:hidden"></textarea>
</div>
    <script src=""></script>
    <script src="/assets/vendor/boilerplate/plugins/codemirror/mode/xml/xml.js"></script>
    <script src="/assets/vendor/boilerplate/plugins/codemirror/mode/css/css.js"></script>
    <script src="/assets/vendor/boilerplate/plugins/codemirror/mode/javascript/javascript.js"></script>
    <script src="/assets/vendor/boilerplate/plugins/codemirror/mode/htmlmixed/htmlmixed.js"></script>
    <script src="/assets/vendor/boilerplate/plugins/codemirror/addon/edit/matchbrackets.js"></script>
    <script src="/assets/vendor/boilerplate/plugins/codemirror/addon/edit/matchtags.js"></script>
    <script src="/assets/vendor/boilerplate/plugins/codemirror/addon/edit/closetag.js"></script>
    <script src="/assets/vendor/boilerplate/plugins/codemirror/addon/fold/xml-fold.js"></script>
    <script src="/assets/vendor/boilerplate/plugins/codemirror/addon/selection/active-line.js"></script>
    <script>$.fn.codemirror.defaults.theme='storm';</script>
    <script>$(function(){$('#test').codemirror({  })});</script>
HTML;

        if ($this->isLaravelEqualOrGreaterThan7) {
            $view = $this->blade('<x-boilerplate::codemirror name="test" id="test" group-id="test" group-class="test" label="test" />@stack("js")');
            $this->assertEquals($expected, $view);
        }

        $view = $this->blade("@component('boilerplate::codemirror', ['name' => 'test', 'id' => 'test', 'group-id' => 'test', 'group-class' => 'test', 'label' => 'test'])@endcomponent()@stack('js')");
        $this->assertEquals($expected, $view);
    }
}
