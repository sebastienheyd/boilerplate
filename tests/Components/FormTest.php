<?php

namespace Sebastienheyd\Boilerplate\Tests\Components;

class FormTest extends TestComponent
{
    public function testFormComponent()
    {
        $expected = <<<'HTML'
<form method="POST" action="">
<input type="hidden" name="_token" value="" autocomplete="off">
</form>
HTML;

        $view = $this->blade('<x-boilerplate::form />');
        $view->assertSee($expected, false);
    }

    public function testFormComponentWithRoute()
    {
        $expected = <<<'HTML'
<form method="POST" action="/admin/users/1/edit">
<input type="hidden" name="_token" value="" autocomplete="off">
</form>
HTML;

        $view = $this->blade('<x-boilerplate::form :route="[\'boilerplate.users.edit\', 1]" />');
        $view->assertSee($expected, false);
    }

    public function testFormComponentWithMethod()
    {
        $expected = <<<'HTML'
<form method="GET" action="">

</form>
HTML;

        $view = $this->blade('<x-boilerplate::form method="get" />');
        $view->assertSee($expected, false);

        $expected = <<<'HTML'
<form method="POST" action="">
<input type="hidden" name="_token" value="" autocomplete="off">    <input type="hidden" name="_method" value="PUT">

</form>
HTML;

        $view = $this->blade('<x-boilerplate::form method="put" />');
        $view->assertSee($expected, false);
    }

    public function testFormComponentWithFiles()
    {
        $expected = <<<'HTML'
<form method="POST" action="" enctype="multipart/form-data">
<input type="hidden" name="_token" value="" autocomplete="off">
</form>
HTML;

        $view = $this->blade('<x-boilerplate::form files />');
        $view->assertSee($expected, false);
    }
}
