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
        $this->app->extend('translation.loader', function ($loader, $app) {
            $paths = [
                base_path('lang'),
                __DIR__.'/resources/laravel-lang',
            ];

            $newLoader = new FileLoader($app['files'], $paths[0], $paths);

            if (method_exists($newLoader, 'addJsonPath')) {
                foreach ($paths as $path) {
                    $newLoader->addJsonPath($path);
                }
            }

            return $newLoader;
        });
    }
}
