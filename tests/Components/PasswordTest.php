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

        if ($this->minLaravelVersion('7.0')) {
            $view = $this->blade('<x-boilerplate::password />');
            $view->assertSee($expected, false);
        }

        $view = $this->blade("@component('boilerplate::password')@endcomponent()");
        $view->assertSee($expected, false);
    }

    public function testPasswordComponent()
    {
        $expected = <<<'HTML'
<div class="form-group">
    <div class="input-group password">
        <input class="form-control" type="password" name="password" placeholder="Password placeholder">
        <div class="input-group-append">
            <button type="button" class="btn" data-toggle="password" tabindex="-1"><i class="far fa-fw fa-eye"></i></button>
        </div>
    </div>
</div>
HTML;

        if ($this->minLaravelVersion('7.0')) {
            $view = $this->blade('<x-boilerplate::password name="password" :check="false" placeholder="Password placeholder" />');
            $view->assertSee($expected, false);
        }

        $view = $this->blade("@component('boilerplate::password', ['name' => 'password', 'check' => false, 'placeholder' => 'Password placeholder'])@endcomponent()");
        $view->assertSee($expected, false);
    }

    public function testPasswordComponentJS()
    {
        $expected = <<<'HTML'
<div class="form-group">
    <div class="input-group password">
        <input class="form-control" type="password" name="password">
        <div class="input-group-append">
            <button type="button" class="btn" data-toggle="password" tabindex="-1"><i class="far fa-fw fa-eye"></i></button>
        </div>
    </div>
</div>
<script>$(()=>{var password_el=$('input[name="password"]');var password_ppv=password_el.popover({title:"Requirements",content:'',placement:'bottom',trigger:'manual',html:!0});password_el.on('keyup focus',function(){let er=[];$.map([[/.{8,}/,"8 characters"],[/[a-z]+/,"One letter"],[/[0-9]+/,"One number"],[/[A-Z]+/,"One capital letter"],[/[^A-Za-z0-9]+/,"One special character"]],function(rule){if(!password_el.val().match(rule[0])){er.push(rule[1])}});if(er.length>0){password_el.data('bs.popover').config.content=er.join('<br>');password_ppv.popover('show')}else{password_ppv.popover('hide')}}).on('blur',()=>{password_ppv.popover('hide')})});</script>
HTML;


        if ($this->minLaravelVersion('7.0')) {
            $view = $this->blade('<x-boilerplate::password name="password" />@stack("js")');
            $view->assertSee($expected, false);
        }

        $view = $this->blade("@component('boilerplate::password', ['name' => 'password'])\n@endcomponent()\n@stack('js')");
        $view->assertSee($expected, false);
    }
}
