<?php

namespace Sebastienheyd\Boilerplate\Tests\Components;

class ColorpickerTest extends TestComponent
{
    public function testColorPickerNoArgs()
    {
        $expected = <<<'HTML'
<code>&lt;x-boilerplate::colorpicker> The name attribute has not been set</code>
HTML;

        if ($this->isLaravelEqualOrGreaterThan7) {
            $view = $this->blade('<x-boilerplate::colorpicker />');
            $this->assertEquals($expected, $view);
        }

        $view = $this->blade("@component('boilerplate::colorpicker') @endcomponent");
        $this->assertEquals($expected, $view);
    }

    public function testColorPickerName()
    {
        $expected = <<<'HTML'
<div class="form-group">
    <input id="test" class="form-control" autocomplete="off" name="test" type="text">
</div>
<script>loadScript('',()=>{loadStylesheet('',()=>{registerAsset('ColorPicker')})})</script><script>whenAssetIsLoaded('ColorPicker',()=>{window.CP_test=$('#test').spectrum({allowEmpty:!0,showInput:!0,showInitial:!0,clickoutFiresChange:!1,locale:'en',showSelectionPalette:!1,})});</script>
HTML;

        if ($this->isLaravelEqualOrGreaterThan7) {
            $view = $this->blade('<x-boilerplate::colorpicker name="test" id="test" />');
            $this->assertEquals($expected, $view);
        }

        $view = $this->blade("@component('boilerplate::colorpicker', ['name' => 'test', 'id' => 'test']) @endcomponent");
        $this->assertEquals($expected, $view);
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

        if ($this->isLaravelEqualOrGreaterThan7) {
            $view = $this->blade('<x-boilerplate::colorpicker name="test" id="test" label="Test" />');
            $this->assertEquals($expected, $view);
        }

        $view = $this->blade("@component('boilerplate::colorpicker', ['name' => 'test', 'id' => 'test', 'label' => 'Test']) @endcomponent");
        $this->assertEquals($expected, $view);
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

        if ($this->isLaravelEqualOrGreaterThan7) {
            $view = $this->blade('<x-boilerplate::colorpicker name="test" id="test" label="Test" group-class="test" group-id="test" class="test" />');
            $this->assertEquals($expected, $view);
        }

        $view = $this->blade("@component('boilerplate::colorpicker', ['name' => 'test', 'id' => 'test', 'label' => 'Test', 'group-class' => 'test', 'group-id' => 'test', 'class' => 'test']) @endcomponent");
        $this->assertEquals($expected, $view);
    }

    public function testColorPickerPalettes()
    {
        $expected = <<<'HTML'
<div class="form-group">
    <input id="test" class="form-control" autocomplete="off" name="test" type="text">
</div>
<script>loadScript('',()=>{loadStylesheet('',()=>{registerAsset('ColorPicker')})})</script><script>whenAssetIsLoaded('ColorPicker',()=>{window.CP_test=$('#test').spectrum({allowEmpty:!0,showInput:!0,showInitial:!0,clickoutFiresChange:!1,locale:'en',showSelectionPalette:!1,palette:["green"],selectionPalette:["red"],})});</script>
HTML;

        if ($this->isLaravelEqualOrGreaterThan7) {
            $view = $this->blade('<x-boilerplate::colorpicker name="test" id="test" :palette="[\'green\']" :selectionPalette="[\'red\']" />');
            $this->assertEquals($expected, $view);

            $view = $this->blade('<x-boilerplate::colorpicker name="test" id="test" :palette="[\'green\']" :selection-palette="[\'red\']" />');
            $this->assertEquals($expected, $view);
        }

        $view = $this->blade("@component('boilerplate::colorpicker', ['name' => 'test', 'id' => 'test', 'palette' => ['green'], 'selectionPalette' => ['red']]) @endcomponent");
        $this->assertEquals($expected, $view);
    }
}
