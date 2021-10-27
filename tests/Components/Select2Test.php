<?php

namespace Sebastienheyd\Boilerplate\Tests\Components;

class Select2Test extends TestComponent
{
    public function testSelect2ComponentNoName()
    {
        $expected = <<<'HTML'
<code>&lt;x-boilerplate::select2> The name attribute has not been set</code>
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
    <select id="test" name="test" class="form-control" data-test="test" style="visibility:hidden;height:1rem">
        <option></option>
        <option value="1">Value 1</option>
    </select>
</div>
<script>loadStylesheet('');loadScript('',()=>{loadScript('',()=>{registerAsset('select2',()=>{$.extend(!0,$.fn.select2.defaults,{language:'en',direction:'ltr'});$(document).on('select2:open',(e)=>{let t=$(e.target);if(t&&t.length){let id=t[0].id||t[0].name;document.querySelector(`input[aria-controls*='${id}']`).focus()}})})})});</script><script>whenAssetIsLoaded('select2',()=>{$('#test').select2({placeholder:'—',allowClear:!1,language:"en",direction:"ltr",minimumInputLength:0,minimumResultsForSearch:10,width:'100%',})})</script>
HTML;

        $view = $this->blade("@component('boilerplate::select2', ['name' => 'test', 'id' => 'test', 'data-test' => 'test'])<option value=\"1\">Value 1</option>@endcomponent()@stack('js')");
        $this->assertEquals($expected, $view);

        // Additionnal space on PHP 7.2, don't know why
        if (version_compare(PHP_VERSION, '7.3', '<')) {
            $expected = preg_replace('#</div>([^<]+)<script#', '</div>$1 <script', $expected);
        }

        if ($this->isLaravelEqualOrGreaterThan7) {
            $view = $this->blade('<x-boilerplate::select2 name="test" id="test" data-test="test"><option value="1">Value 1</option></x-boilerplate::select2>@stack("js")');
            $this->assertEquals($expected, $view);
        }
    }

    public function testSelect2ComponentOptions()
    {
        $expected = <<<'HTML'
<div class="form-group">
    <select id="test" name="test" class="form-control" data-test="test" style="visibility:hidden;height:1rem">
        <option></option>
        <option value="1">Value 1</option>
    </select>
</div>
<script>loadStylesheet('');loadScript('',()=>{loadScript('',()=>{registerAsset('select2',()=>{$.extend(!0,$.fn.select2.defaults,{language:'en',direction:'ltr'});$(document).on('select2:open',(e)=>{let t=$(e.target);if(t&&t.length){let id=t[0].id||t[0].name;document.querySelector(`input[aria-controls*='${id}']`).focus()}})})})});</script><script>whenAssetIsLoaded('select2',()=>{$('#test').select2({placeholder:'—',allowClear:!1,language:"en",direction:"ltr",minimumInputLength:0,minimumResultsForSearch:10,width:'100%',})})</script>
HTML;

        $view = $this->blade("@component('boilerplate::select2', ['name' => 'test', 'id' => 'test', 'data-test' => 'test', 'options' => [1 => 'Value 1']])@endcomponent()@stack('js')");
        $this->assertEquals($expected, $view);

        // Additionnal space on PHP 7.2, don't know why
        if (version_compare(PHP_VERSION, '7.3', '<')) {
            $expected = preg_replace('#</div>([^<]+)<script#', '</div>$1 <script', $expected);
        }

        if ($this->isLaravelEqualOrGreaterThan7) {
            $view = $this->blade('<x-boilerplate::select2 name="test" id="test" data-test="test"><option value="1">Value 1</option></x-boilerplate::select2>@stack("js")');
            $this->assertEquals($expected, $view);
        }
    }
}
