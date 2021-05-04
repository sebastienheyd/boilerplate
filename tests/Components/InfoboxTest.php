<?php

namespace Sebastienheyd\Boilerplate\Tests\Components;

class InfoboxTest extends TestComponent
{
    public function testInfoboxComponentEmpty()
    {
        $expected = <<<'HTML'
<div class="info-box bg-white">
    <span class="info-box-icon bg-info">
        <i class="fas fa-cubes"></i>
    </span>
    <div class="info-box-content">
        <span class="info-box-text"></span>
        <span class="info-box-number"></span>
    </div>
</div>
HTML;

        if ($this->isLaravelEqualOrGreaterThan7) {
            $view = $this->blade('<x-boilerplate::infobox />');
            $this->assertEquals($expected, $view);
        }

        $view = $this->blade("@component('boilerplate::infobox') @endcomponent");
        $this->assertEquals($expected, $view);
    }

    public function testInputFull()
    {
        $expected = <<<'HTML'
<div class="info-box bg-red extra-class" id="test">
    <span class="info-box-icon bg-red">
        <i class="far fa-envelope"></i>
    </span>
    <div class="info-box-content">
        <span class="info-box-text">test</span>
        <span class="info-box-number">1234</span>
        <div class="progress"><div class="progress-bar" style="width:50%"></div></div>
        <span class="progress-description">desc</span>
    </div>
</div>
HTML;

        if ($this->isLaravelEqualOrGreaterThan7) {
            $view = $this->blade('<x-boilerplate::infobox icon="far fa-envelope" class="extra-class" color="red" bg-color="red" text="test" number="1234" progress="50" description="desc" id="test" />');
            $this->assertEquals($expected, $view);
        }

        $view = $this->blade("@component('boilerplate::infobox', ['icon' => 'far fa-envelope', 'class' => 'extra-class', 'color' => 'red', 'bg-color' => 'red' , 'text' => 'test', 'number' => '1234', 'progress' => '50', 'description' => 'desc', 'id' => 'test']) @endcomponent");
        $this->assertEquals($expected, $view);
    }
}
