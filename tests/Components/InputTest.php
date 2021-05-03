<?php

namespace Sebastienheyd\Boilerplate\Tests\Components;

class InputTest extends TestComponent
{
    public function testInputComponentNoName()
    {
        $expected = <<<HTML
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
        $expected = <<<HTML
<div class="form-group">
    <label for="test">Test</label>
    <input class="form-control" name="test" type="text" value="" id="test">
</div>
HTML;

        if ($this->isLaravelEqualOrGreaterThan7) {
            $view = $this->blade('<x-boilerplate::input name="test" />');
            $this->assertEquals($expected, $view);
        }

        $view = $this->blade("@component('boilerplate::input', ['name' => 'test']) @endcomponent");
        $this->assertEquals($expected, $view);
    }

    public function testInputComponentWithClass()
    {
        $expected = <<<HTML
<div class="form-group">
    <label for="test">Test</label>
    <input class="form-control test-field" name="test" type="text" value="" id="test">
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
        $expected = <<<HTML
<div class="form-group">
    <label for="test">Test</label>
    <input class="form-control test-field" data-attr="test" name="test" type="text" value="" id="test">
</div>
HTML;

        if ($this->isLaravelEqualOrGreaterThan7) {
            $view = $this->blade('<x-boilerplate::input name="test" class="test-field" data-attr="test" />');
            $this->assertEquals($expected, $view);
        }

        $view = $this->blade("@component('boilerplate::input', ['name' => 'test', 'class' => 'test-field', 'data-attr' => 'test']) @endcomponent");
        $this->assertEquals($expected, $view);
    }

    public function testInputComponentPassword()
    {
        $expected = <<<HTML
<div class="form-group">
    <label for="test">Test</label>
    <input class="form-control" name="test" type="password" value="" id="test">
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
        $expected = <<<HTML
<div class="form-group">
    <label for="fielderror">Fielderror</label>
    <input class="form-control is-invalid" name="fielderror" type="text" value="" id="fielderror">
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
        $expected = <<<HTML
<div class="form-group">
    <label for="fielderror">Fielderror</label>
    <input class="form-control is-invalid" name="fielderror" type="text" value="" id="fielderror">
    <div class="error-bubble"><div>Error message</div></div>
    <small class="form-text text-muted">The user will receive an invitation by e-mail to login in which it will allow him to enter his new password</small>
</div>
HTML;

        if ($this->isLaravelEqualOrGreaterThan7) {
            $view = $this->blade('<x-boilerplate::input name="fielderror" help="boilerplate::users.create.help" />');
            $this->assertEquals($expected, $view);
        }

        $view = $this->blade("@component('boilerplate::input', ['name' => 'fielderror', 'help' => 'boilerplate::users.create.help']) @endcomponent");
        $this->assertEquals($expected, $view);
    }
}
