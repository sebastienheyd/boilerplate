<?php

namespace Sebastienheyd\Boilerplate;

use Illuminate\Translation\TranslationServiceProvider as LaravelTranslationServiceProvider;

class TranslationServiceProvider extends LaravelTranslationServiceProvider
{
    /**
     * Register the translation line loader.
     */
    protected function registerLoader()
    {
        $this->app->singleton('translation.loader', function ($app) {
            $loader = new FileLoader($app['files'], $app['path.lang'], [__DIR__.'/resources/laravel-lang']);

            if (\is_callable([$loader, 'addJsonPath'])) {
                $loader->addJsonPath(__DIR__.'/resources/laravel-lang');
            }

            return $loader;
        });
    }
}