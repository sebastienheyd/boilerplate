<?php

namespace Sebastienheyd\Boilerplate\Tests\Components;

class TinymceTest extends TestComponent
{
    public function testTinymceComponent()
    {
        if ($this->isLaravelEqualOrGreaterThan7) {
            $view = $this->blade('<x-boilerplate::tinymce id="test" />@stack("js")');
            $this->assertTrue(preg_match("#tinymce\.defaultSettings#", $view) !== false);
            $this->assertTrue(preg_match('#<textarea id="test"></textarea>#', $view) !== false);
            $this->assertTrue(preg_match("#$\('\#test'\)\.tinymce\(\{\}\)#", $view) !== false);
        }

        $view = $this->blade("@component('boilerplate::tinymce', ['id' => 'test'])@endcomponent()@stack('js')");
        $this->assertTrue(preg_match("#tinymce\.defaultSettings#", $view) !== false);
        $this->assertTrue(preg_match('#<textarea id="test"></textarea>#', $view) !== false);
        $this->assertTrue(preg_match("#$\('\#test'\).tinymce\(\{\}\)#", $view) !== false);
    }
}
