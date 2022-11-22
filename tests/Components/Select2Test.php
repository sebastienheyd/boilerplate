<?php

namespace Sebastienheyd\Boilerplate\Tests\Components;

class Select2Test extends TestComponent
{
    public function testSelect2ComponentNoName()
    {
        $expected = <<<'HTML'
<code>&lt;x-boilerplate::select2> The name attribute has not been set</code>
HTML;

        if ($this->isLaravelEqualOrGreaterThan7()) {
            $view = $this->blade('<x-boilerplate::select2 />');
            $view->assertSee($expected, false);
        }

        $view = $this->blade("@component('boilerplate::select2')@endcomponent()");
        $view->assertSee($expected, false);
    }

    public function testSelect2ComponentAttributes()
    {
        $expected = <<<'HTML'
<div class="form-group">
    <select id="test" name="test" class="form-control" data-test="test" style="visibility:hidden;height:1rem" autocomplete="off">
        <option></option>
        <option value="1">Value 1</option>
    </select>
</div>
<script>loadStylesheet('');loadScript('',()=>{loadScript('',()=>{registerAsset('select2',()=>{$.extend(!0,$.fn.select2.defaults,{language:'en',direction:'ltr'});$(document).on('select2:open',(e)=>{let t=$(e.target);if(t&&t.length){let id=t[0].id||t[0].name;document.querySelector(`input[aria-controls*='${id}']`).focus()}})})})});</script><script>whenAssetIsLoaded('select2',()=>{window.S2_test=$('#test').select2({placeholder:'—',allowClear:!1,language:"en",direction:"ltr",minimumInputLength:0,minimumResultsForSearch:10,width:'100%',dropdownAutoWidth:!0,dropdownParent:$('#test').parent(),tags:!1,escapeMarkup:function(markup){return markup},})})</script>
HTML;

        if ($this->isLaravelEqualOrGreaterThan7()) {
            $view = $this->blade('<x-boilerplate::select2 name="test" id="test" data-test="test"><option value="1">Value 1</option></x-boilerplate::select2>@stack("js")');
            $view->assertSee($expected, false);
        }

        $view = $this->blade("@component('boilerplate::select2', ['name' => 'test', 'id' => 'test', 'data-test' => 'test'])<option value=\"1\">Value 1</option>@endcomponent()@stack('js')");
        $view->assertSee($expected, false);
    }

    public function testSelect2ComponentOptions()
    {
        $expected = <<<'HTML'
<div class="form-group">
    <select id="test" name="test" class="form-control" data-test="test" style="visibility:hidden;height:1rem" autocomplete="off">
        <option></option>
        <option value="1">Value 1</option>
    </select>
</div>
<script>loadStylesheet('');loadScript('',()=>{loadScript('',()=>{registerAsset('select2',()=>{$.extend(!0,$.fn.select2.defaults,{language:'en',direction:'ltr'});$(document).on('select2:open',(e)=>{let t=$(e.target);if(t&&t.length){let id=t[0].id||t[0].name;document.querySelector(`input[aria-controls*='${id}']`).focus()}})})})});</script><script>whenAssetIsLoaded('select2',()=>{window.S2_test=$('#test').select2({placeholder:'—',allowClear:!1,language:"en",direction:"ltr",minimumInputLength:0,minimumResultsForSearch:10,width:'100%',dropdownAutoWidth:!0,dropdownParent:$('#test').parent(),tags:!1,escapeMarkup:function(markup){return markup},})})</script>
HTML;

        if ($this->isLaravelEqualOrGreaterThan7()) {
            $view = $this->blade('<x-boilerplate::select2 name="test" id="test" data-test="test"><option value="1">Value 1</option></x-boilerplate::select2>@stack("js")');
            $view->assertSee($expected, false);
        }

        $view = $this->blade("@component('boilerplate::select2', ['name' => 'test', 'id' => 'test', 'data-test' => 'test', 'options' => [1 => 'Value 1']])@endcomponent()@stack('js')");
        $view->assertSee($expected, false);
    }

    public function testSelect2Model()
    {
        $expected = <<<'HTML'
<div class="form-group">
    <select id="test" name="user" class="form-control" style="visibility:hidden;height:1rem" autocomplete="off">
        <option></option>
        
    </select>
</div>
<script>loadStylesheet('');loadScript('',()=>{loadScript('',()=>{registerAsset('select2',()=>{$.extend(!0,$.fn.select2.defaults,{language:'en',direction:'ltr'});$(document).on('select2:open',(e)=>{let t=$(e.target);if(t&&t.length){let id=t[0].id||t[0].name;document.querySelector(`input[aria-controls*='${id}']`).focus()}})})})});</script><script>whenAssetIsLoaded('select2',()=>{window.S2_test=$('#test').select2({placeholder:'—',allowClear:!1,language:"en",direction:"ltr",minimumInputLength:1,minimumResultsForSearch:10,width:'100%',dropdownAutoWidth:!0,dropdownParent:$('#test').parent(),tags:!1,escapeMarkup:function(markup){return markup},ajax:{delay:200,url:'/admin/select2',data:function(param){return{q:param.term,length:10,m:"",}},method:'post'}})})</script>
HTML;

        if ($this->isLaravelEqualOrGreaterThan7()) {
            $view = $this->blade('<x-boilerplate::select2 id="test" model="Sebastienheyd\Boilerplate\Models\User,first_name" />@stack("js")');
            $view = preg_replace('#m:"([^"]*)"#', 'm:""', trim($view));
            $this->assertEquals($expected, $view);
        }

        $view = $this->blade("@component('boilerplate::select2', ['id' => 'test', 'model' => 'Sebastienheyd\Boilerplate\Models\User,first_name'])@endcomponent()@stack('js')");
        $view = preg_replace('#m:"([^"]*)"#', 'm:""', trim($view));
        $this->assertEquals($expected, $view);
    }

    public function testSelect2BadFormat()
    {
        if ($this->isLaravelEqualOrGreaterThan7()) {
            $this->expectException(\ErrorException::class);
            $this->expectExceptionMessage('Select2 component model format is incorrect');
            $this->blade('<x-boilerplate::select2 id="test" model="BadModel" />@stack("js")');
        }

        $this->expectException(\ErrorException::class);
        $this->expectExceptionMessage('Select2 component model format is incorrect');
        $this->blade("@component('boilerplate::select2', ['id' => 'test', 'model' => 'BadModel'])@endcomponent()@stack('js')");
    }

    public function testSelect2BadModel()
    {
        if ($this->isLaravelEqualOrGreaterThan7()) {
            $this->expectException(\ErrorException::class);
            $this->expectExceptionMessage('Select2 component model does not exists');
            $this->blade('<x-boilerplate::select2 id="test" model="BadModel,first_name" />@stack("js")');
        }

        $this->expectException(\ErrorException::class);
        $this->expectExceptionMessage('Select2 component model does not exists');
        $this->blade("@component('boilerplate::select2', ['id' => 'test', 'model' => 'BadModel,first_name'])@endcomponent()@stack('js')");
    }

    public function testSelect2BadModelInstance()
    {
        if ($this->isLaravelEqualOrGreaterThan7()) {
            $this->expectException(\ErrorException::class);
            $this->expectExceptionMessage('Select2 component model is not an instance of Illuminate\Database\Eloquent\Model');
            $this->blade('<x-boilerplate::select2 id="test" model="Sebastienheyd\Boilerplate\Controllers\Select2Controller,first_name" />@stack("js")');
        }

        $this->expectException(\ErrorException::class);
        $this->expectExceptionMessage('Select2 component model is not an instance of Illuminate\Database\Eloquent\Model');
        $this->blade("@component('boilerplate::select2', ['id' => 'test', 'model' => 'Sebastienheyd\Boilerplate\Controllers\Select2Controller,first_name'])@endcomponent()@stack('js')");
    }

    public function testSelect2SelectedModel()
    {
        $expected = <<<'HTML'
<div class="form-group">
    <select id="test" name="permission" class="form-control" style="visibility:hidden;height:1rem" autocomplete="off">
        <option></option>
        <option value="1" selected>backend_access</option>
    </select>
</div>
<script>loadStylesheet('');loadScript('',()=>{loadScript('',()=>{registerAsset('select2',()=>{$.extend(!0,$.fn.select2.defaults,{language:'en',direction:'ltr'});$(document).on('select2:open',(e)=>{let t=$(e.target);if(t&&t.length){let id=t[0].id||t[0].name;document.querySelector(`input[aria-controls*='${id}']`).focus()}})})})});</script><script>whenAssetIsLoaded('select2',()=>{window.S2_test=$('#test').select2({placeholder:'—',allowClear:!1,language:"en",direction:"ltr",minimumInputLength:1,minimumResultsForSearch:10,width:'100%',dropdownAutoWidth:!0,dropdownParent:$('#test').parent(),tags:!1,escapeMarkup:function(markup){return markup},ajax:{delay:200,url:'/admin/select2',data:function(param){return{q:param.term,length:10,m:"",}},method:'post'}})})</script>
HTML;

        if ($this->isLaravelEqualOrGreaterThan7()) {
            $view = $this->blade('<x-boilerplate::select2 id="test" model="Sebastienheyd\Boilerplate\Models\Permission,name" :selected="[1]" />@stack("js")');
            $view = preg_replace('#m:"([^"]*)"#', 'm:""', trim($view));
            $this->assertEquals($expected, $view);
        }

        $view = $this->blade("@component('boilerplate::select2', ['id' => 'test', 'model' => 'Sebastienheyd\Boilerplate\Models\Permission,name', 'selected' => [1]])@endcomponent()@stack('js')");
        $view = preg_replace('#m:"([^"]*)"#', 'm:""', trim($view));
        $this->assertEquals($expected, $view);
    }
}
