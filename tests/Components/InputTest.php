<?php

namespace Sebastienheyd\Boilerplate\Tests\Components;

class InputTest extends TestComponent
{
    public function testInputComponentNoName()
    {
        $expected = <<<'HTML'
<code>
    &lt;x-boilerplate::input>
    The name attribute has not been set
</code>
HTML;

        if ($this->minLaravelVersion('7.0')) {
            $view = $this->blade('<x-boilerplate::input />');
            $view->assertSee($expected, false);
        }

        $view = $this->blade("@component('boilerplate::input') @endcomponent");
        $view->assertSee($expected, false);
    }

    public function testInputComponent()
    {
        $expected = <<<'HTML'
<div class="form-group">
    <input class="form-control" autocomplete="off" name="test" type="text" value="">
</div>
HTML;

        if ($this->minLaravelVersion('7.0')) {
            $view = $this->blade('<x-boilerplate::input name="test" />');
            $view->assertSee($expected, false);
        }

        $view = $this->blade("@component('boilerplate::input', ['name' => 'test']) @endcomponent");
        $view->assertSee($expected, false);
    }

    public function testInputComponentWithLabel()
    {
        $expected = <<<'HTML'
<div class="form-group">
    <label>Test</label>
    <input class="form-control" autocomplete="off" name="test" type="text" value="">
</div>
HTML;

        if ($this->minLaravelVersion('7.0')) {
            $view = $this->blade('<x-boilerplate::input name="test" label="Test" />');
            $view->assertSee($expected, false);
        }

        $view = $this->blade("@component('boilerplate::input', ['name' => 'test', 'label' => 'Test']) @endcomponent");
        $view->assertSee($expected, false);
    }

    public function testInputComponentWithClass()
    {
        $expected = <<<'HTML'
<div class="form-group">
    <input class="form-control test-field" autocomplete="off" name="test" type="text" value="">
</div>
HTML;

        if ($this->minLaravelVersion('7.0')) {
            $view = $this->blade('<x-boilerplate::input name="test" class="test-field" />');
            $view->assertSee($expected, false);
        }

        $view = $this->blade("@component('boilerplate::input', ['name' => 'test', 'class' => 'test-field']) @endcomponent");
        $view->assertSee($expected, false);
    }

    public function testInputComponentWithAttributes()
    {
        $expected = <<<'HTML'
<div class="form-group">
    <div class="input-clearable">
    <span class="fa fa-times fa-xs"></span>
    <input class="form-control test-field" data-attr="test" autocomplete="off" name="test" type="text" value="">
    </div>
</div>
HTML;

        if ($this->minLaravelVersion('7.0')) {
            $view = $this->blade('<x-boilerplate::input name="test" class="test-field" data-attr="test" :clearable="true" />');
            $view->assertSee($expected, false);
        }

        $view = $this->blade("@component('boilerplate::input', ['name' => 'test', 'class' => 'test-field', 'data-attr' => 'test', 'clearable' => true]) @endcomponent");
        $view->assertSee($expected, false);
    }

    public function testInputComponentPassword()
    {
        $expected = <<<'HTML'
<div class="form-group">
    <input class="form-control" autocomplete="off" name="test" type="password" value="">
</div>
HTML;

        if ($this->minLaravelVersion('7.0')) {
            $view = $this->blade('<x-boilerplate::input name="test" type="password" />');
            $view->assertSee($expected, false);
        }

        $view = $this->blade("@component('boilerplate::input', ['name' => 'test', 'type' => 'password']) @endcomponent");
        $view->assertSee($expected, false);
    }

    public function testInputComponentError()
    {
        $expected = <<<'HTML'
<div class="form-group">
    <input class="form-control is-invalid" autocomplete="off" name="fielderror" type="text" value="">
    <div class="error-bubble"><div>Error message</div></div>
</div>
HTML;

        if ($this->minLaravelVersion('7.0')) {
            $view = $this->withoutMix()->withViewErrors(['fielderror' => 'Error message'])->rawBlade('<x-boilerplate::input name="fielderror" />');
            $view->assertSee($expected, false);
        }

        $view =  $this->withoutMix()->withViewErrors(['fielderror' => 'Error message'])->rawBlade("@component('boilerplate::input', ['name' => 'fielderror']) @endcomponent");
        $view->assertSee($expected, false);
    }

    public function testInputComponentHelp()
    {
        $expected = <<<'HTML'
<div class="form-group">
    <input class="form-control is-invalid" autocomplete="off" name="fielderror" type="text" value="">
    <small class="form-text text-muted">The user will receive an invitation by e-mail to login in which it will allow him to enter his new password</small>
    <div class="error-bubble"><div>Error message</div></div>
</div>
HTML;

        if ($this->minLaravelVersion('7.0')) {
            $view =  $this->withoutMix()->withViewErrors(['fielderror' => 'Error message'])->rawBlade('<x-boilerplate::input name="fielderror" help="boilerplate::users.create.help" />');
            $view->assertSee($expected, false);
        }

        $view = $this->withoutMix()->withViewErrors(['fielderror' => 'Error message'])->rawBlade("@component('boilerplate::input', ['name' => 'fielderror', 'help' => 'boilerplate::users.create.help']) @endcomponent");
        $view->assertSee($expected, false);
    }

    public function testInputComponentPrependAppend()
    {
        $expected = <<<'HTML'
<div class="form-group">
    <div class="input-group">
        <div class="input-group-prepend">
            <span class="input-group-text">test</span>
        </div>
    <input class="form-control" autocomplete="off" name="test" type="text" value="">
        <div class="input-group-append">
            <span class="input-group-text">test</span>
        </div>
    </div>
</div>
HTML;

        if ($this->minLaravelVersion('7.0')) {
            $view = $this->blade('<x-boilerplate::input name="test" prepend-text="test" append-text="test" />');
            $view->assertSee($expected, false);
        }

        $view = $this->blade("@component('boilerplate::input', ['name' => 'test', 'prepend-text' => 'test', 'append-text' => 'test']) @endcomponent");
        $view->assertSee($expected, false);
    }

    public function testInputComponentPrependAppendIcon()
    {
        $expected = <<<'HTML'
<div class="form-group">
    <div class="input-group">
        <div class="input-group-prepend">
            <span class="input-group-text"><span class="fas fa-envelope"></span></span>
        </div>
    <input class="form-control" autocomplete="off" name="test" type="text" value="">
        <div class="input-group-append">
            <span class="input-group-text"><span class="fas fa-envelope"></span></span>
        </div>
    </div>
</div>
HTML;

        if ($this->minLaravelVersion('7.0')) {
            $view = $this->blade('<x-boilerplate::input name="test" prepend-text="fas fa-envelope" append-text="fas fa-envelope" />');
            $view->assertSee($expected, false);
        }

        $view = $this->blade("@component('boilerplate::input', ['name' => 'test', 'prepend-text' => 'fas fa-envelope', 'append-text' => 'fas fa-envelope']) @endcomponent");
        $view->assertSee($expected, false);
    }

    public function testInputComponentPrependAppendSlot()
    {
        $expected = <<<'HTML'
<div class="form-group">
    <div class="input-group">
        <div class="input-group-prepend">
            test
        </div>
    <input class="form-control" autocomplete="off" name="test" type="text" value="">
        <div class="input-group-append">
            test
        </div>
    </div>
</div>
HTML;

        if ($this->minLaravelVersion('7.0')) {
            $view = $this->blade('<x-boilerplate::input name="test"><x-slot name="prepend">test</x-slot><x-slot name="append">test</x-slot></x-boilerplate::input>');
            $view->assertSee($expected, false);
        }

        $view = $this->blade("@component('boilerplate::input', ['name' => 'test']) @slot('prepend') test @endslot @slot('append') test @endslot @endcomponent");
        $view->assertSee($expected, false);
    }

    public function testInputPlaceholder()
    {
        $expected = <<<'HTML'
<div class="form-group">
    <input class="form-control" placeholder="Test" autocomplete="off" name="test" type="text" value="">
</div>
HTML;

        if ($this->minLaravelVersion('7.0')) {
            $view = $this->blade('<x-boilerplate::input name="test" placeholder="Test" />');
            $view->assertSee($expected, false);
        }

        $view = $this->blade("@component('boilerplate::input', ['name' => 'test', 'placeholder' => 'Test']) @endcomponent");
        $view->assertSee($expected, false);
    }
}
