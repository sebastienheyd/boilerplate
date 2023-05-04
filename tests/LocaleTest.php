<?php

namespace Sebastienheyd\Boilerplate\Tests;

use Illuminate\Support\Facades\App;

class LocaleTest extends TestCase
{
    public function testValidLocale()
    {
        app()->setLocale('fr');
        $this->assertEquals('Inscription', __('Register'));
    }

    public function testInexistantLocaleFile()
    {
        app()->setLocale('fr-US');
        $this->assertEquals('Inscription', __('Register'));
    }

    public function testBadLocaleFile()
    {
        $this->artisan('vendor:publish', ['--tag' => 'boilerplate-lang']);
        $path = App::langPath();
        $this->assertTrue(file_exists($path.'/fr.json'));
        file_put_contents($path.'/fr.json', 'bad');

        $this->assertTrue(file_exists($path.'/vendor/boilerplate/fr.json'));

        app()->setLocale('fr');
        $this->expectException(\RuntimeException::class);
        __('Register');
    }
}