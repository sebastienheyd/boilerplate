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

        if ($this->isLaravelEqualOrGreaterThan7) {
            $view = $this->blade('<x-boilerplate::form />');
            $this->assertEquals($expected, $view);
        }

        $view = $this->blade("@component('boilerplate::form') @endcomponent");
        $this->assertEquals($expected, $view);
    }

    public function testFormComponentWithURL()
    {
        $expected = <<<'HTML'
<form method="POST" action="https://www.google.fr/search" accept-charset="UTF-8"><input name="_token" type="hidden">

</form>
HTML;

        if ($this->isLaravelEqualOrGreaterThan7) {
            $view = $this->blade('<x-boilerplate::form url="https://www.google.fr/search" />');
            $this->assertEquals($expected, $view);
        }

        $view = $this->blade("@component('boilerplate::form', ['url' => 'https://www.google.fr/search']) @endcomponent");
        $this->assertEquals($expected, $view);
    }

    public function testFormComponentWithRoute()
    {
        $expected = <<<'HTML'
<form method="POST" action="http://localhost/admin/users/1/edit" accept-charset="UTF-8"><input name="_token" type="hidden">

</form>
HTML;

        if ($this->isLaravelEqualOrGreaterThan7) {
            $view = $this->blade('<x-boilerplate::form :route="[\'boilerplate.users.edit\', 1]" />');
            $this->assertEquals($expected, $view);
        }

        $view = $this->blade("@component('boilerplate::form', ['route' => ['boilerplate.users.edit', 1]]) @endcomponent");
        $this->assertEquals($expected, $view);
    }

    public function testFormComponentWithMethod()
    {
        $expected = <<<'HTML'
<form method="GET" action="http://localhost" accept-charset="UTF-8">

</form>
HTML;

        if ($this->isLaravelEqualOrGreaterThan7) {
            $view = $this->blade('<x-boilerplate::form method="get" />');
            $this->assertEquals($expected, $view);
        }

        $view = $this->blade("@component('boilerplate::form', ['method' => 'get']) @endcomponent");
        $this->assertEquals($expected, $view);

        $expected = <<<'HTML'
<form method="POST" action="http://localhost" accept-charset="UTF-8"><input name="_method" type="hidden" value="PUT"><input name="_token" type="hidden">

</form>
HTML;

        if ($this->isLaravelEqualOrGreaterThan7) {
            $view = $this->blade('<x-boilerplate::form method="put" />');
            $this->assertEquals($expected, $view);
        }

        $view = $this->blade("@component('boilerplate::form', ['method' => 'put']) @endcomponent");
        $this->assertEquals($expected, $view);
    }

    public function testFormComponentWithFiles()
    {
        $expected = <<<'HTML'
<form method="POST" action="http://localhost" accept-charset="UTF-8" enctype="multipart/form-data"><input name="_token" type="hidden">

</form>
HTML;

        if ($this->isLaravelEqualOrGreaterThan7) {
            $view = $this->blade('<x-boilerplate::form files />');
            $this->assertEquals($expected, $view);
        }

        $view = $this->blade("@component('boilerplate::form', ['files' => true]) @endcomponent");
        $this->assertEquals($expected, $view);
    }
}
