<?php

namespace Sebastienheyd\Boilerplate\Tests\Components;

class FormTest extends TestComponent
{
    public function testFormComponent()
    {
        $expected = <<<'HTML'
<form method="POST" action="http://localhost" accept-charset="UTF-8"><input name="_token" type="hidden">

</form>
HTML;

        if ($this->minLaravelVersion('7.0')) {
            $view = $this->blade('<x-boilerplate::form />');
            $view->assertSee($expected, false);
        }

        $view = $this->blade("@component('boilerplate::form') @endcomponent");
        $view->assertSee($expected, false);
    }

    public function testFormComponentWithURL()
    {
        $expected = <<<'HTML'
<form method="POST" action="https://www.google.fr/search" accept-charset="UTF-8"><input name="_token" type="hidden">

</form>
HTML;

        if ($this->minLaravelVersion('7.0')) {
            $view = $this->blade('<x-boilerplate::form url="https://www.google.fr/search" />');
            $view->assertSee($expected, false);
        }

        $view = $this->blade("@component('boilerplate::form', ['url' => 'https://www.google.fr/search']) @endcomponent");
        $view->assertSee($expected, false);
    }

    public function testFormComponentWithRoute()
    {
        $expected = <<<'HTML'
<form method="POST" action="http://localhost/admin/users/1/edit" accept-charset="UTF-8"><input name="_token" type="hidden">

</form>
HTML;

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
<form method="GET" action="http://localhost" accept-charset="UTF-8">

</form>
HTML;

        if ($this->minLaravelVersion('7.0')) {
            $view = $this->blade('<x-boilerplate::form method="get" />');
            $view->assertSee($expected, false);
        }

        $view = $this->blade("@component('boilerplate::form', ['method' => 'get']) @endcomponent");
        $view->assertSee($expected, false);

        $expected = <<<'HTML'
<form method="POST" action="http://localhost" accept-charset="UTF-8"><input name="_method" type="hidden" value="PUT"><input name="_token" type="hidden">

</form>
HTML;

        if ($this->minLaravelVersion('7.0')) {
            $view = $this->blade('<x-boilerplate::form method="put" />');
            $view->assertSee($expected, false);
        }

        $view = $this->blade("@component('boilerplate::form', ['method' => 'put']) @endcomponent");
        $view->assertSee($expected, false);
    }

    public function testFormComponentWithFiles()
    {
        $expected = <<<'HTML'
<form method="POST" action="http://localhost" accept-charset="UTF-8" enctype="multipart/form-data"><input name="_token" type="hidden">

</form>
HTML;

        if ($this->minLaravelVersion('7.0')) {
            $view = $this->blade('<x-boilerplate::form files />');
            $view->assertSee($expected, false);
        }

        $view = $this->blade("@component('boilerplate::form', ['files' => true]) @endcomponent");
        $view->assertSee($expected, false);
    }
}
