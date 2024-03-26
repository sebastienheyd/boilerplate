<?php

namespace Sebastienheyd\Boilerplate\Tests\Components;

class FormTest extends TestComponent
{
    public function testFormComponent()
    {
        if ($this->minLaravelVersion('10.24.0')) {
            $expected = <<<'HTML'
<form method="POST" action="">
<input type="hidden" name="_token" value="" autocomplete="off">
</form>
HTML;
        } else {
            $expected = <<<'HTML'
<form method="POST" action="">
<input type="hidden" name="_token" value="">
</form>
HTML;
        }

        if ($this->minLaravelVersion('7.0')) {
            $view = $this->blade('<x-boilerplate::form />');
            $view->assertSee($expected, false);
        }

        $view = $this->blade("@component('boilerplate::form') @endcomponent");
        $view->assertSee($expected, false);
    }

    public function testFormComponentWithRoute()
    {
        if ($this->minLaravelVersion('10.24.0')) {
            $expected = <<<'HTML'
<form method="POST" action="/admin/users/1/edit">
<input type="hidden" name="_token" value="" autocomplete="off">
</form>
HTML;
        } else {
            $expected = <<<'HTML'
<form method="POST" action="/admin/users/1/edit">
<input type="hidden" name="_token" value="">
</form>
HTML;
        }

        if ($this->minLaravelVersion('7.0')) {
            $view = $this->blade('<x-boilerplate::form :route="[\'boilerplate.users.edit\', 1]" />');
            $view->assertSee($expected, false);
        }

        $view = $this->blade("@component('boilerplate::form', ['route' => ['boilerplate.users.edit', 1]]) @endcomponent");
        $view->assertSee($expected, false);
    }

    public function testFormComponentWithMethod()
    {
        $expected = <<<'HTML'
<form method="GET" action="">

</form>
HTML;

        if ($this->minLaravelVersion('7.0')) {
            $view = $this->blade('<x-boilerplate::form method="get" />');
            $view->assertSee($expected, false);
        }

        $view = $this->blade("@component('boilerplate::form', ['method' => 'get']) @endcomponent");
        $view->assertSee($expected, false);

        if ($this->minLaravelVersion('10.24.0')) {
            $expected = <<<'HTML'
<form method="POST" action="">
<input type="hidden" name="_token" value="" autocomplete="off">    <input type="hidden" name="_method" value="PUT">

</form>
HTML;
        } else {
            $expected = <<<'HTML'
<form method="POST" action="">
<input type="hidden" name="_token" value="">    <input type="hidden" name="_method" value="PUT">

</form>
HTML;
        }

        if ($this->minLaravelVersion('7.0')) {
            $view = $this->blade('<x-boilerplate::form method="put" />');
            $view->assertSee($expected, false);
        }

        $view = $this->blade("@component('boilerplate::form', ['method' => 'put']) @endcomponent");
        $view->assertSee($expected, false);
    }

    public function testFormComponentWithFiles()
    {
        if ($this->minLaravelVersion('10.24.0')) {
            $expected = <<<'HTML'
<form method="POST" action="" enctype="multipart/form-data">
<input type="hidden" name="_token" value="" autocomplete="off">
</form>
HTML;
        } else {
            $expected = <<<'HTML'
<form method="POST" action="" enctype="multipart/form-data">
<input type="hidden" name="_token" value="">
</form>
HTML;
        }

        if ($this->minLaravelVersion('7.0')) {
            $view = $this->blade('<x-boilerplate::form files />');
            $view->assertSee($expected, false);
        }

        $view = $this->blade("@component('boilerplate::form', ['files' => true]) @endcomponent");
        $view->assertSee($expected, false);
    }
}
