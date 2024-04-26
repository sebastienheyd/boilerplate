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

        $view = $this->blade('<x-boilerplate::input />');
        $view->assertSee($expected, false);
    }

    public function testInputComponent()
    {
        $expected = <<<'HTML'
<div class="form-group">
    <input class="form-control" type="text" name="test" value autocomplete="off">
</div>
HTML;

        $view = $this->blade('<x-boilerplate::input name="test" />');
        $view->assertSee($expected, false);
    }

    public function testInputComponentWithLabel()
    {
        $expected = <<<'HTML'
<div class="form-group">
    <label>Test</label>
    <input class="form-control" type="text" name="test" value autocomplete="off">
</div>
HTML;

        $view = $this->blade('<x-boilerplate::input name="test" label="Test" />');
        $view->assertSee($expected, false);
    }

    public function testInputComponentWithClass()
    {
        $expected = <<<'HTML'
<div class="form-group">
    <input class="form-control test-field" type="text" name="test" value autocomplete="off">
</div>
HTML;

        $view = $this->blade('<x-boilerplate::input name="test" class="test-field" />');
        $view->assertSee($expected, false);
    }

    public function testInputComponentWithAttributes()
    {
        $expected = <<<'HTML'
<div class="form-group">
    <div class="input-clearable">
    <span class="fa fa-times fa-xs"></span>
    <input class="form-control test-field" type="text" name="test" value data-attr="test" autocomplete="off">
    </div>
</div>
HTML;

        $view = $this->blade('<x-boilerplate::input name="test" class="test-field" data-attr="test" :clearable="true" />');
        $view->assertSee($expected, false);
    }

    public function testInputComponentPassword()
    {
        $expected = <<<'HTML'
<div class="form-group">
    <input class="form-control" type="password" name="test" autocomplete="off">
</div>
HTML;

        $view = $this->blade('<x-boilerplate::input name="test" type="password" />');
        $view->assertSee($expected, false);
    }

    public function testInputComponentError()
    {
        $expected = <<<'HTML'
<div class="form-group">
    <input class="form-control is-invalid" type="text" name="fielderror" value autocomplete="off">
    <div class="error-bubble"><div>Error message</div></div>
</div>
HTML;

        $view = $this->withoutMix()->withViewErrors(['fielderror' => 'Error message'])->rawBlade('<x-boilerplate::input name="fielderror" />');
        $view->assertSee($expected, false);
    }

    public function testInputComponentHelp()
    {
        $expected = <<<'HTML'
<div class="form-group">
    <input class="form-control is-invalid" type="text" name="fielderror" value autocomplete="off">
    <small class="form-text text-muted">The user will receive an invitation by e-mail to login in which it will allow him to enter his new password</small>
    <div class="error-bubble"><div>Error message</div></div>
</div>
HTML;

        $view = $this->withoutMix()->withViewErrors(['fielderror' => 'Error message'])->rawBlade('<x-boilerplate::input name="fielderror" help="boilerplate::users.create.help" />');
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
    <input class="form-control" type="text" name="test" value autocomplete="off">
        <div class="input-group-append">
            <span class="input-group-text">test</span>
        </div>
    </div>
</div>
HTML;

        $view = $this->blade('<x-boilerplate::input name="test" prepend-text="test" append-text="test" />');
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
    <input class="form-control" type="text" name="test" value autocomplete="off">
        <div class="input-group-append">
            <span class="input-group-text"><span class="fas fa-envelope"></span></span>
        </div>
    </div>
</div>
HTML;

        $view = $this->blade('<x-boilerplate::input name="test" prepend-text="fas fa-envelope" append-text="fas fa-envelope" />');
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
    <input class="form-control" type="text" name="test" value autocomplete="off">
        <div class="input-group-append">
            test
        </div>
    </div>
</div>
HTML;

        $view = $this->blade('<x-boilerplate::input name="test"><x-slot name="prepend">test</x-slot><x-slot name="append">test</x-slot></x-boilerplate::input>');
        $view->assertSee($expected, false);
    }

    public function testInputPlaceholder()
    {
        $expected = <<<'HTML'
<div class="form-group">
    <input class="form-control" type="text" name="test" value placeholder="Test" autocomplete="off">
</div>
HTML;

        $view = $this->blade('<x-boilerplate::input name="test" placeholder="Test" />');
        $view->assertSee($expected, false);
    }

    public function testNumberType()
    {
        $expected = <<<'HTML'
<div class="form-group">
    <input class="form-control" type="number" name="test" value autocomplete="off">
</div>
HTML;

        $view = $this->blade('<x-boilerplate::input type="number" name="test" />');
        $view->assertSee($expected, false);
    }

    public function testFileType()
    {
        $expected = <<<'HTML'
<div class="form-group">
    <input class="form-control-file" type="file" name="test" autocomplete="off">
</div>
HTML;

        $view = $this->blade('<x-boilerplate::input type="file" name="test" />');
        $view->assertSee($expected, false);
    }

    public function testSelectType()
    {
        $expected = <<<'HTML'
<div class="form-group">
    <select class="form-control" name="test" autocomplete="off"><option value="value" selected="selected">test</option></select>
</div>
HTML;

        $view = $this->blade('<x-boilerplate::input type="select" name="test" :options="[\'value\' => \'test\']" value="value" />');
        $view->assertSee($expected, false);
    }

    public function testTextarea()
    {
        $expected = <<<'HTML'
<div class="form-group">
    <textarea class="form-control" name="test" rows="12" autocomplete="off">value</textarea>
</div>
HTML;

        $view = $this->blade('<x-boilerplate::input type="textarea" name="test" value="value" rows="12" />');
        $view->assertSee($expected, false);
    }
}
