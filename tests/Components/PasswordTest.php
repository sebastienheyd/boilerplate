<?php

namespace Sebastienheyd\Boilerplate\Tests\Components;

class PasswordTest extends TestComponent
{
    public function testPasswordComponentNoName()
    {
        $expected = <<<'HTML'
<code>
    &lt;x-boilerplate::password>
    The name attribute has not been set
</code>
HTML;

        if ($this->isLaravelEqualOrGreaterThan7) {
            $view = $this->blade('<x-boilerplate::password />');
            $this->assertEquals($expected, $view);
        }

        $view = $this->blade("@component('boilerplate::password')@endcomponent()");
        $this->assertEquals($expected, $view);
    }

    public function testPasswordComponent()
    {
        $expected = <<<'HTML'
<div class="form-group">
    <div class="input-group password">
        <input class="form-control" name="password" type="password" value="">
        <div class="input-group-append">
            <button type="button" class="btn" data-toggle="password" tabindex="-1"><i class="far fa-fw fa-eye"></i></button>
        </div>
    </div>
</div>
HTML;

        if ($this->isLaravelEqualOrGreaterThan7) {
            $view = $this->blade('<x-boilerplate::password name="password" :check="false" />');
            $this->assertEquals($expected, $view);
        }

        $view = $this->blade("@component('boilerplate::password', ['name' => 'password', 'check' => false])@endcomponent()");
        $this->assertEquals($expected, $view);
    }

    public function testPasswordComponentJS()
    {
        $expected = <<<'HTML'
<div class="form-group">
    <div class="input-group password">
        <input class="form-control" name="password" type="password" value="">
        <div class="input-group-append">
            <button type="button" class="btn" data-toggle="password" tabindex="-1"><i class="far fa-fw fa-eye"></i></button>
        </div>
    </div>
</div>
<script>$(()=>{var password_el=$('input[name="password"]');var password_ppv=password_el.popover({title:"Requirements",content:'',placement:'bottom',trigger:'manual',html:!0});password_el.on('keyup focus',function(){let er=[];$.map([[/.{8,}/,"8 characters"],[/[a-z]+/,"One letter"],[/[0-9]+/,"One number"],[/[A-Z]+/,"One capital letter"],[/[^A-Za-z0-9]+/,"One special character"]],function(rule){if(!password_el.val().match(rule[0])){er.push(rule[1])}});if(er.length>0){password_el.data('bs.popover').config.content=er.join('<br/>');password_ppv.popover('show')}else{password_ppv.popover('hide')}}).on('blur',()=>{password_ppv.popover('hide')})});</script>
HTML;

        if ($this->isLaravelEqualOrGreaterThan7) {
            $view = $this->blade('<x-boilerplate::password name="password" />@stack("js")');
            $this->assertEquals($expected, $view);
        }

        $view = $this->blade("@component('boilerplate::password', ['name' => 'password'])@endcomponent()@stack('js')");
        $this->assertEquals($expected, $view);
    }
}
