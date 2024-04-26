<?php

namespace Sebastienheyd\Boilerplate\Tests\Components;

class DaterangepickerTest extends TestComponent
{
    public function testDaterangepickerNoArgs()
    {
        $expected = <<<'HTML'
<code>&lt;x-boilerplate::daterangepicker> The name attribute has not been set</code>
HTML;

        $view = $this->blade('<x-boilerplate::daterangepicker />');
        $view->assertSee($expected, false);
    }

    public function testDaterangepickerName()
    {
        $expected = <<<'HTML'
<div class="form-group">
    <div class="input-group" id="range">
        <div class="d-flex align-items-center form-control">
            <input class="daterangepicker-input" type="text" name="range[value]" value autocomplete="off">
            <span class="fa fa-fw fa-times fa-xs ml-1 clear-daterangepicker" data-name="range" style="display:none"/>
        </div>
    </div>
    <input type="hidden" name="range[start]" value autocomplete="off">
    <input type="hidden" name="range[end]" value autocomplete="off">
</div>
<script>loadScript('',()=>{moment.locale('en');registerAsset('momentjs')});</script><script>loadStylesheet("");whenAssetIsLoaded('momentjs',()=>{loadScript("",()=>{registerAsset('daterangepicker');$.fn.daterangepicker.defaultOptions={locale:{"applyLabel":"Apply","cancelLabel":"Cancel","fromLabel":"From","toLabel":"To","customRangeLabel":"Custom",}}})});</script><script>whenAssetIsLoaded('daterangepicker',()=>{window.DRP_range=$('input[name="range[value]"]').daterangepicker({showDropdowns:!0,opens:"right",timePicker:!1,timePickerIncrement:1,timePicker24Hour:!0,timePickerSeconds:!1,autoUpdateInput:!1,startDate:moment(),endDate:moment(),locale:{format:'YYYY-MM-DD'}}).on('apply.daterangepicker',applyDateRangePicker)});</script>
HTML;

        $view = $this->blade('<x-boilerplate::daterangepicker name="range" id="range" />');
        $view->assertSee($expected, false);
    }

    public function testDaterangepickerAttributes()
    {
        $expected = <<<'HTML'
<div class="form-group">
    <div class="input-group" id="range">
        <div class="input-group-prepend">
            <span class="input-group-text"><span class="fas fa-calendar"></span></span>
        </div>
        <div class="d-flex align-items-center form-control">
            <input class="daterangepicker-input" type="text" name="range[value]" value autocomplete="off">
            <span class="fa fa-fw fa-times fa-xs ml-1 clear-daterangepicker" data-name="range" style="display:none"/>
        </div>
        <div class="input-group-append">
            <span class="input-group-text"><span class="fas fa-clock"></span></span>
        </div>
    </div>
    <small class="form-text text-muted">Help text</small>
    <input type="hidden" name="range[start]" value="1970-01-01 00:00:00" autocomplete="off">
    <input type="hidden" name="range[end]" value="1970-01-01 00:00:00" autocomplete="off">
</div>
<script>loadScript('',()=>{moment.locale('en');registerAsset('momentjs')});</script><script>loadStylesheet("");whenAssetIsLoaded('momentjs',()=>{loadScript("",()=>{registerAsset('daterangepicker');$.fn.daterangepicker.defaultOptions={locale:{"applyLabel":"Apply","cancelLabel":"Cancel","fromLabel":"From","toLabel":"To","customRangeLabel":"Custom",}}})});</script><script>whenAssetIsLoaded('daterangepicker',()=>{window.DRP_range=$('input[name="range[value]"]').daterangepicker({showDropdowns:!0,opens:"right",timePicker:!1,timePickerIncrement:1,timePicker24Hour:!0,timePickerSeconds:!1,autoUpdateInput:!0,startDate:moment("1970-01-01 00:00:00"),endDate:moment("2021-11-20 09:27:57"),locale:{format:'YYYY-MM-DD'}}).on('apply.daterangepicker',applyDateRangePicker)});</script>
HTML;

        $view = $this->blade('<x-boilerplate::daterangepicker name="range" id="range" prepend-text="fas fa-calendar" appendText="fas fa-clock" help="Help text" start="1970-01-01 00:00:00" :end="date(\'Y-m-d H:i:s\', 1637400477)" />');
        $view->assertSee($expected, false);
    }

    public function testDateRangepickerMinMaxDate()
    {
        $expected = <<<'HTML'
<div class="form-group">
    <div class="input-group" id="range">
        <div class="d-flex align-items-center form-control">
            <input class="daterangepicker-input" type="text" name="range[value]" value autocomplete="off">
            <span class="fa fa-fw fa-times fa-xs ml-1 clear-daterangepicker" data-name="range" style="display:none"/>
        </div>
    </div>
    <input type="hidden" name="range[start]" value autocomplete="off">
    <input type="hidden" name="range[end]" value autocomplete="off">
</div>
<script>loadScript('',()=>{moment.locale('en');registerAsset('momentjs')});</script><script>loadStylesheet("");whenAssetIsLoaded('momentjs',()=>{loadScript("",()=>{registerAsset('daterangepicker');$.fn.daterangepicker.defaultOptions={locale:{"applyLabel":"Apply","cancelLabel":"Cancel","fromLabel":"From","toLabel":"To","customRangeLabel":"Custom",}}})});</script><script>whenAssetIsLoaded('daterangepicker',()=>{window.DRP_range=$('input[name="range[value]"]').daterangepicker({showDropdowns:!0,opens:"right",minDate:moment('1970-01-01 00:00:00'),maxDate:moment('2022-11-16 00:00:00'),timePicker:!1,timePickerIncrement:1,timePicker24Hour:!0,timePickerSeconds:!1,autoUpdateInput:!1,startDate:moment(),endDate:moment(),locale:{format:'YYYY-MM-DD'}}).on('apply.daterangepicker',applyDateRangePicker)});</script>
HTML;

        $view = $this->blade('<x-boilerplate::daterangepicker name="range" id="range" min-date="1970-01-01 00:00:00" max-date="2022-11-16 00:00:00" />');
        $view->assertSee($expected, false);
    }

    public function testDateRangepickerTimePicker()
    {
        $expected = <<<'HTML'
<div class="form-group">
    <div class="input-group" id="range">
        <div class="d-flex align-items-center form-control">
            <input class="daterangepicker-input" type="text" name="range[value]" value autocomplete="off">
            <span class="fa fa-fw fa-times fa-xs ml-1 clear-daterangepicker" data-name="range" style="display:none"/>
        </div>
    </div>
    <input type="hidden" name="range[start]" value autocomplete="off">
    <input type="hidden" name="range[end]" value autocomplete="off">
</div>
<script>loadScript('',()=>{moment.locale('en');registerAsset('momentjs')});</script><script>loadStylesheet("");whenAssetIsLoaded('momentjs',()=>{loadScript("",()=>{registerAsset('daterangepicker');$.fn.daterangepicker.defaultOptions={locale:{"applyLabel":"Apply","cancelLabel":"Cancel","fromLabel":"From","toLabel":"To","customRangeLabel":"Custom",}}})});</script><script>whenAssetIsLoaded('daterangepicker',()=>{window.DRP_range=$('input[name="range[value]"]').daterangepicker({showDropdowns:!0,opens:"right",timePicker:!0,timePickerIncrement:1,timePicker24Hour:!1,timePickerSeconds:!0,autoUpdateInput:!1,startDate:moment(),endDate:moment(),locale:{format:'YYYY-MM-DD hh:mm:ss A'}}).on('apply.daterangepicker',applyDateRangePicker)});</script>
HTML;

        $view = $this->blade('<x-boilerplate::daterangepicker name="range" id="range" :timePicker="true" :timePickerSeconds="true" :timePicker24Hour="false" />');
        $view->assertSee($expected, false);
    }
}
