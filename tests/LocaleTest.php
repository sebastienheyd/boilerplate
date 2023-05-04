<?php

namespace Sebastienheyd\Boilerplate\Tests;

use Illuminate\Support\Facades\App;

class LocaleTest extends TestCase
{
    public function testValidLocale()
    {
        app()->setLocale('fr');
        $this->assertEquals('Inscription', __('Register'));
        $this->assertEquals('prix', __('validation.attributes.price'));
    }

    public function testDefaultLocale()
    {
        $this->assertEquals('Register', __('Register'));
        $this->assertEquals('price', __('validation.attributes.price'));
    }

    public function testNonExistentLang()
    {
        app()->setLocale('zz');
        $this->assertEquals('Register', __('Register'));
        $this->assertEquals('price', __('validation.attributes.price'));
    }

    public function testNonInexistentLocaleFile()
    {
        app()->setLocale('fr-US');
        $this->assertEquals('Inscription', __('Register'));
        $this->assertEquals('prix', __('validation.attributes.price'));
    }

    public function testBadJsonLocaleFile()
    {
        $this->artisan('vendor:publish', ['--tag' => 'boilerplate-lang', '--force' => true]);
        $path = App::langPath();
        $this->assertTrue(file_exists($path.'/fr.json'));
        file_put_contents($path.'/fr.json', 'bad');

        $this->assertTrue(file_exists($path.'/vendor/boilerplate/fr.json'));

        app()->setLocale('fr');
        $this->expectException(\RuntimeException::class);
        __('Register');
    }

    public function testBadPhpLocaleFile()
    {
        $this->artisan('vendor:publish', ['--tag' => 'boilerplate-lang', '--force' => true]);
        $path = App::langPath();
        $this->assertTrue(file_exists($path.'/fr/validation.php'));
        file_put_contents($path.'/fr/validation.php', '');

        app()->setLocale('fr');
        $this->expectException(\RuntimeException::class);
        __('validation.attributes.price');
    }

    public function testPublishedJsonLocaleFile()
    {
        $this->artisan('vendor:publish', ['--tag' => 'boilerplate-lang', '--force' => true]);
        $path = App::langPath();

        $str = file_get_contents($path.'/fr.json');
        $str = str_replace('Inscription', 'Test value', $str);
        file_put_contents($path.'/fr.json', $str);

        app()->setLocale('fr');
        $this->assertEquals('Test value', __('Register'));
    }

    public function testPublishedPhpLocaleFile()
    {
        $this->artisan('vendor:publish', ['--tag' => 'boilerplate-lang', '--force' => true]);
        $path = App::langPath();

        $str = file_get_contents($path.'/fr/validation.php');
        $str = str_replace('prix', 'Test value', $str);
        file_put_contents($path.'/fr/validation.php', $str);

        app()->setLocale('fr');
        $this->assertEquals('Test value', __('validation.attributes.price'));
    }
}
