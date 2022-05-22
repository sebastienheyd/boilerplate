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

        if ($this->isLaravelEqualOrGreaterThan7) {
            $view = $this->blade('<x-boilerplate::input />');
            $this->assertEquals($expected, $view);
        }

        $view = $this->blade("@component('boilerplate::input') @endcomponent");
        $this->assertEquals($expected, $view);
    }

    public function testInputComponent()
    {
        $expected = <<<'HTML'
<div class="form-group">
    <input class="form-control" autocomplete="off" name="test" type="text" value="">
</div>
HTML;

        if ($this->isLaravelEqualOrGreaterThan7) {
            $view = $this->blade('<x-boilerplate::input name="test" />');
            $this->assertEquals($expected, $view);
        }

        $view = $this->blade("@component('boilerplate::input', ['name' => 'test']) @endcomponent");
        $this->assertEquals($expected, $view);
    }

    public function testInputComponentWithLabel()
    {
        $expected = <<<'HTML'
<div class="form-group">
    <label>Test</label>
    <input class="form-control" autocomplete="off" name="test" type="text" value="">
</div>
HTML;

        if ($this->isLaravelEqualOrGreaterThan7) {
            $view = $this->blade('<x-boilerplate::input name="test" label="Test" />');
            $this->assertEquals($expected, $view);
        }

        $view = $this->blade("@component('boilerplate::input', ['name' => 'test', 'label' => 'Test']) @endcomponent");
        $this->assertEquals($expected, $view);
    }

    public function testInputComponentWithClass()
    {
        $expected = <<<'HTML'
<div class="form-group">
    <input class="form-control test-field" autocomplete="off" name="test" type="text" value="">
</div>
HTML;

        if ($this->isLaravelEqualOrGreaterThan7) {
            $view = $this->blade('<x-boilerplate::input name="test" class="test-field" />');
            $this->assertEquals($expected, $view);
        }

        $view = $this->blade("@component('boilerplate::input', ['name' => 'test', 'class' => 'test-field']) @endcomponent");
        $this->assertEquals($expected, $view);
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

        if ($this->isLaravelEqualOrGreaterThan7) {
            $view = $this->blade('<x-boilerplate::input name="test" class="test-field" data-attr="test" :clearable="true" />');
            $this->assertEquals($expected, $view);
        }

        $view = $this->blade("@component('boilerplate::input', ['name' => 'test', 'class' => 'test-field', 'data-attr' => 'test', 'clearable' => true]) @endcomponent");
        $this->assertEquals($expected, $view);
    }

    public function testInputComponentPassword()
    {
        $expected = <<<'HTML'
<div class="form-group">
    <input class="form-control" autocomplete="off" name="test" type="password" value="">
</div>
HTML;

        if ($this->isLaravelEqualOrGreaterThan7) {
            $view = $this->blade('<x-boilerplate::input name="test" type="password" />');
            $this->assertEquals($expected, $view);
        }

        $view = $this->blade("@component('boilerplate::input', ['name' => 'test', 'type' => 'password']) @endcomponent");
        $this->assertEquals($expected, $view);
    }

    public function testInputComponentError()
    {
        $expected = <<<'HTML'
<div class="form-group">
    <input class="form-control is-invalid" autocomplete="off" name="fielderror" type="text" value="">
    <div class="error-bubble"><div>Error message</div></div>
</div>
HTML;

        if ($this->isLaravelEqualOrGreaterThan7) {
            $view = $this->blade('<x-boilerplate::input name="fielderror" />');
            $this->assertEquals($expected, $view);
        }

        $view = $this->blade("@component('boilerplate::input', ['name' => 'fielderror']) @endcomponent");
        $this->assertEquals($expected, $view);
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

        if ($this->isLaravelEqualOrGreaterThan7) {
            $view = $this->blade('<x-boilerplate::input name="fielderror" help="boilerplate::users.create.help" />');
            $this->assertEquals($expected, $view);
        }

        $view = $this->blade("@component('boilerplate::input', ['name' => 'fielderror', 'help' => 'boilerplate::users.create.help']) @endcomponent");
        $this->assertEquals($expected, $view);
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

        if ($this->isLaravelEqualOrGreaterThan7) {
            $view = $this->blade('<x-boilerplate::input name="test" prepend-text="test" append-text="test" />');
            $this->assertEquals($expected, $view);
        }

        $view = $this->blade("@component('boilerplate::input', ['name' => 'test', 'prepend-text' => 'test', 'append-text' => 'test']) @endcomponent");
        $this->assertEquals($expected, $view);
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

        if ($this->isLaravelEqualOrGreaterThan7) {
            $view = $this->blade('<x-boilerplate::input name="test" prepend-text="fas fa-envelope" append-text="fas fa-envelope" />');
            $this->assertEquals($expected, $view);
        }

        $view = $this->blade("@component('boilerplate::input', ['name' => 'test', 'prepend-text' => 'fas fa-envelope', 'append-text' => 'fas fa-envelope']) @endcomponent");
        $this->assertEquals($expected, $view);
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

        if ($this->isLaravelEqualOrGreaterThan7) {
            $view = $this->blade('<x-boilerplate::input name="test"><x-slot name="prepend">test</x-slot><x-slot name="append">test</x-slot></x-boilerplate::input>');
            $this->assertEquals($expected, $view);
        }

        $view = $this->blade("@component('boilerplate::input', ['name' => 'test']) @slot('prepend') test @endslot @slot('append') test @endslot @endcomponent");
        $this->assertEquals($expected, $view);
    }
}
