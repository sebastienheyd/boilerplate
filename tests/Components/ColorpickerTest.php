<?php

namespace Sebastienheyd\Boilerplate\Tests\Components;

class ColorpickerTest extends TestComponent
{
    public function testColorPickerNoArgs()
    {
        $expected = <<<'HTML'
<code>&lt;x-boilerplate::colorpicker> The name attribute has not been set</code>
HTML;

        if ($this->minLaravelVersion('7.0')) {
            $view = $this->blade('<x-boilerplate::colorpicker />');
            $view->assertSee($expected, false);
        }

        $view = $this->blade("@component('boilerplate::colorpicker') @endcomponent");
        $view->assertSee($expected, false);
    }

    public function testColorPickerName()
    {
        $expected = <<<'HTML'
<div class="form-group">
    <input id="test" class="form-control" autocomplete="off" name="test" type="text">
</div>
<script>loadScript('',()=>{loadStylesheet('',()=>{registerAsset('ColorPicker')})})</script><script>whenAssetIsLoaded('ColorPicker',()=>{window.CP_test=$('#test').spectrum({allowEmpty:!0,showInput:!0,showInitial:!0,clickoutFiresChange:!1,locale:'en',showSelectionPalette:!1,})});</script>
HTML;

        if ($this->minLaravelVersion('7.0')) {
            $view = $this->blade('<x-boilerplate::colorpicker name="test" id="test" />');
            $view->assertSee($expected, false);
        }

        $view = $this->blade("@component('boilerplate::colorpicker', ['name' => 'test', 'id' => 'test']) @endcomponent");
        $view->assertSee($expected, false);
    }

    public function testColorPickerLabel()
    {
        $expected = <<<'HTML'
<div class="form-group">
    <label>Test</label>
    <input id="test" class="form-control" autocomplete="off" name="test" type="text">
</div>
<script>loadScript('',()=>{loadStylesheet('',()=>{registerAsset('ColorPicker')})})</script><script>whenAssetIsLoaded('ColorPicker',()=>{window.CP_test=$('#test').spectrum({allowEmpty:!0,showInput:!0,showInitial:!0,clickoutFiresChange:!1,locale:'en',showSelectionPalette:!1,})});</script>
HTML;

        if ($this->minLaravelVersion('7.0')) {
            $view = $this->blade('<x-boilerplate::colorpicker name="test" id="test" label="Test" />');
            $view->assertSee($expected, false);
        }

        $view = $this->blade("@component('boilerplate::colorpicker', ['name' => 'test', 'id' => 'test', 'label' => 'Test']) @endcomponent");
        $view->assertSee($expected, false);
    }

    public function testColorPickerClasses()
    {
        $expected = <<<'HTML'
<div class="form-group test" id="test">
    <label>Test</label>
    <input id="test" class="form-control test" autocomplete="off" name="test" type="text">
</div>
<script>loadScript('',()=>{loadStylesheet('',()=>{registerAsset('ColorPicker')})})</script><script>whenAssetIsLoaded('ColorPicker',()=>{window.CP_test=$('#test').spectrum({allowEmpty:!0,showInput:!0,showInitial:!0,clickoutFiresChange:!1,locale:'en',showSelectionPalette:!1,})});</script>
HTML;

        if ($this->minLaravelVersion('7.0')) {
            $view = $this->blade('<x-boilerplate::colorpicker name="test" id="test" label="Test" group-class="test" group-id="test" class="test" />');
            $view->assertSee($expected, false);
        }

        $view = $this->blade("@component('boilerplate::colorpicker', ['name' => 'test', 'id' => 'test', 'label' => 'Test', 'group-class' => 'test', 'group-id' => 'test', 'class' => 'test']) @endcomponent");
        $view->assertSee($expected, false);
    }

    public function testColorPickerPalettes()
    {
        $expected = <<<'HTML'
<div class="form-group">
    <input id="test" class="form-control" autocomplete="off" name="test" type="text">
</div>
<script>loadScript('',()=>{loadStylesheet('',()=>{registerAsset('ColorPicker')})})</script><script>whenAssetIsLoaded('ColorPicker',()=>{window.CP_test=$('#test').spectrum({allowEmpty:!0,showInput:!0,showInitial:!0,clickoutFiresChange:!1,locale:'en',showSelectionPalette:!1,palette:["green"],selectionPalette:["red"],})});</script>
HTML;

        if ($this->minLaravelVersion('7.0')) {
            $view = $this->blade('<x-boilerplate::colorpicker name="test" id="test" :palette="[\'green\']" :selectionPalette="[\'red\']" />');
            $view->assertSee($expected, false);

            $view = $this->blade('<x-boilerplate::colorpicker name="test" id="test" :palette="[\'green\']" :selection-palette="[\'red\']" />');
            $view->assertSee($expected, false);
        }

        $view = $this->blade("@component('boilerplate::colorpicker', ['name' => 'test', 'id' => 'test', 'palette' => ['green'], 'selectionPalette' => ['red']]) @endcomponent");
        $view->assertSee($expected, false);
    }
}
