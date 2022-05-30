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
    <textarea id="test" name="test" style="visibility:hidden" rows="0"></textarea>
</div>
<script>loadStylesheet('',()=>{loadStylesheet('/assets/vendor/boilerplate/plugins/codemirror/theme/storm.css',()=>{loadScript('',()=>{loadScript("/assets/vendor/boilerplate/plugins/codemirror/mode/xml/xml.js",()=>{loadScript("/assets/vendor/boilerplate/plugins/codemirror/mode/css/css.js",()=>{loadScript("/assets/vendor/boilerplate/plugins/codemirror/mode/javascript/javascript.js",()=>{loadScript("/assets/vendor/boilerplate/plugins/codemirror/mode/htmlmixed/htmlmixed.js",()=>{loadScript("/assets/vendor/boilerplate/plugins/codemirror/addon/edit/matchtags.js",()=>{loadScript("/assets/vendor/boilerplate/plugins/codemirror/addon/edit/matchbrackets.js",()=>{loadScript("/assets/vendor/boilerplate/plugins/codemirror/addon/edit/closetag.js",()=>{loadScript("/assets/vendor/boilerplate/plugins/codemirror/addon/fold/xml-fold.js",()=>{loadScript("/assets/vendor/boilerplate/plugins/codemirror/addon/selection/active-line.js",()=>{registerAsset('CodeMirror',()=>{$.fn.codemirror.defaults.theme='storm'})})})})})})})})})})})})});</script><script>whenAssetIsLoaded('CodeMirror',()=>{let uid=getIntervalUid();intervals[uid]=setInterval(function(){if($('#test').is(':visible')){clearInterval(intervals[uid]);window.CM_test=$('#test').codemirror({})}})})</script>
HTML;

        if ($this->isLaravelEqualOrGreaterThan7) {
            $view = $this->blade('<x-boilerplate::codemirror name="test" id="test" group-id="test" group-class="test" label="test" />@stack("js")');
            $this->assertEquals($expected, $view);
        }

        $view = $this->blade("@component('boilerplate::codemirror', ['name' => 'test', 'id' => 'test', 'group-id' => 'test', 'group-class' => 'test', 'label' => 'test'])@endcomponent()@stack('js')");
        $this->assertEquals($expected, $view);
    }
}
