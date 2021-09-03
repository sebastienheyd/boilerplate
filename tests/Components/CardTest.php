<?php

namespace Sebastienheyd\Boilerplate\Tests\Components;

class CardTest extends TestComponent
{
    public function testCardComponent()
    {
        $expected = <<<'HTML'
<div class="card card-outline card-info">
    <div class="card-body">test</div>
</div>
HTML;

        if ($this->isLaravelEqualOrGreaterThan7) {
            $view = $this->blade('<x-boilerplate::card>test</x-boilerplate::card>');
            $this->assertEquals($expected, $view);
        }

        $view = $this->blade("@component('boilerplate::card') test @endcomponent");
        $this->assertEquals($expected, $view);
    }

    public function testCardComponentColor()
    {
        $expected = <<<'HTML'
<div class="card card-outline card-primary">
    <div class="card-body">test</div>
</div>
HTML;

        if ($this->isLaravelEqualOrGreaterThan7) {
            $view = $this->blade('<x-boilerplate::card color="primary">test</x-boilerplate::card>');
            $this->assertEquals($expected, $view);
        }

        $view = $this->blade("@component('boilerplate::card', ['color' => 'primary']) test @endcomponent");
        $this->assertEquals($expected, $view);
    }

    public function testCardComponentbgColor()
    {
        $expected = <<<'HTML'
<div class="card card-outline card-primary bg-primary">
    <div class="card-body">test</div>
</div>
HTML;

        if ($this->isLaravelEqualOrGreaterThan7) {
            $view = $this->blade('<x-boilerplate::card color="primary" bg-color="primary">test</x-boilerplate::card>');
            $this->assertEquals($expected, $view);
        }

        $view = $this->blade("@component('boilerplate::card', ['color' => 'primary', 'bg-color' => 'primary']) test @endcomponent");
        $this->assertEquals($expected, $view);
    }

    public function testCardComponentWithoutOutline()
    {
        $expected = <<<'HTML'
<div class="card card-info">
    <div class="card-body">test</div>
</div>
HTML;

        if ($this->isLaravelEqualOrGreaterThan7) {
            $view = $this->blade('<x-boilerplate::card :outline=false>test</x-boilerplate::card>');
            $this->assertEquals($expected, $view);
        }

        $view = $this->blade("@component('boilerplate::card', ['outline' => false]) test @endcomponent");
        $this->assertEquals($expected, $view);
    }

    public function testCardComponentWithTitle()
    {
        $expected = <<<'HTML'
<div class="card card-outline card-info">
    <div class="card-header border-bottom-0">
        <h3 class="card-title">Dashboard</h3>
    </div>
    <div class="card-body pt-0">test</div>
</div>
HTML;

        if ($this->isLaravelEqualOrGreaterThan7) {
            $view = $this->blade('<x-boilerplate::card title="boilerplate::layout.dashboard">test</x-boilerplate::card>');
            $this->assertEquals($expected, $view);
        }

        $view = $this->blade("@component('boilerplate::card', ['title' => 'boilerplate::layout.dashboard']) test @endcomponent");
        $this->assertEquals($expected, $view);
    }

    public function testCardComponentWithTitleAndTools()
    {
        $expected = <<<'HTML'
<div class="card card-outline card-info">
    <div class="card-header border-bottom-0">
        <h3 class="card-title">title</h3>
        <div class="card-tools">
            <a href="#">close</a>
        </div>
    </div>
    <div class="card-body pt-0">test</div>
</div>
HTML;

        if ($this->isLaravelEqualOrGreaterThan7) {
            $view = $this->blade('<x-boilerplate::card title="title"><x-slot name="tools"><a href="#">close</a></x-slot> test</x-boilerplate::card>');
            $this->assertEquals($expected, $view);
        }

        $view = $this->blade("@component('boilerplate::card', ['title' => 'title'])@slot('tools')<a href=\"#\">close</a> @endslot test @endcomponent");
        $this->assertEquals($expected, $view);
    }

    public function testCardComponentWithAllTools()
    {
        $expected = <<<'HTML'
<div class="card card-outline card-info collapsed-card">
    <div class="card-header border-bottom-0">
        <h3 class="card-title">title</h3>
        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="maximize"><i class="fas fa-expand"></i></button>
            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-plus"></i></button>
            <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
        </div>
    </div>
    <div class="card-body pt-0">test</div>
</div>
HTML;

        if ($this->isLaravelEqualOrGreaterThan7) {
            $view = $this->blade('<x-boilerplate::card title="title" maximize reduce close collapsed>test</x-boilerplate::card>');
            $this->assertEquals($expected, $view);
        }

        $view = $this->blade("@component('boilerplate::card', ['title' => 'title', 'maximize' => true, 'reduce' => true, 'close' => true, 'collapsed' => true]) test @endcomponent");
        $this->assertEquals($expected, $view);
    }

    public function testCardComponentWithHeader()
    {
        $expected = <<<'HTML'
<div class="card card-outline card-info">
    <div class="card-header border-bottom-0">
        <a href="#">link</a>
    </div>
    <div class="card-body">test</div>
</div>
HTML;

        if ($this->isLaravelEqualOrGreaterThan7) {
            $view = $this->blade('<x-boilerplate::card><x-slot name="header"><a href="#">link</a></x-slot> test</x-boilerplate::card>');
            $this->assertEquals($expected, $view);
        }

        $view = $this->blade("@component('boilerplate::card')@slot('header')<a href=\"#\">link</a> @endslot test @endcomponent");
        $this->assertEquals($expected, $view);
    }

    public function testCardComponentWithFooter()
    {
        $expected = <<<'HTML'
<div class="card card-outline card-info">
    <div class="card-body">test</div>
    <div class="card-footer"><a href="#">link</a></div>
</div>
HTML;

        if ($this->isLaravelEqualOrGreaterThan7) {
            $view = $this->blade('<x-boilerplate::card><x-slot name="footer"><a href="#">link</a></x-slot> test</x-boilerplate::card>');
            $this->assertEquals($expected, $view);
        }

        $view = $this->blade("@component('boilerplate::card')@slot('footer')<a href=\"#\">link</a> @endslot test @endcomponent");
        $this->assertEquals($expected, $view);
    }

    public function testCardComponentWithTabs()
    {
        $expected = <<<'HTML'
<div class="card card-outline card-outline-tabs card-info">
    <div class="card-body">test</div>
</div>
HTML;

        if ($this->isLaravelEqualOrGreaterThan7) {
            $view = $this->blade('<x-boilerplate::card tabs="true">test</x-boilerplate::card>');
            $this->assertEquals($expected, $view);
        }

        $view = $this->blade("@component('boilerplate::card', ['tabs' => true]) test @endcomponent");
        $this->assertEquals($expected, $view);
    }

    public function testCardComponentWithAttributes()
    {
        $expected = <<<'HTML'
<div class="card card-info extra-class" id="test" data-test="ok">
    <div class="card-body">test</div>
</div>
HTML;

        if ($this->isLaravelEqualOrGreaterThan7) {
            $view = $this->blade('<x-boilerplate::card :outline=false id="test" class="extra-class" data-test="ok">test</x-boilerplate::card>');
            $this->assertEquals($expected, $view);
        }

        $view = $this->blade("@component('boilerplate::card', ['outline' => false, 'id' => 'test', 'data-test' => 'ok', 'class' => 'extra-class']) test @endcomponent");
        $this->assertEquals($expected, $view);
    }
}
