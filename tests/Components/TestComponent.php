<?php

namespace Sebastienheyd\Boilerplate\Tests\Components;

use Illuminate\Foundation\Application as Laravel;
use Illuminate\Support\Facades\View as ViewFacade;
use Illuminate\Support\MessageBag;
use Illuminate\Support\ViewErrorBag;
use Sebastienheyd\Boilerplate\Tests\TestCase;

abstract class TestComponent extends TestCase
{
    protected function blade(string $template, $data = [])
    {
        $this->withoutMix()->withViewErrors([]);
        return $this->rawBlade($template, $data);
    }

    protected function rawBlade(string $template, $data = [])
    {
        $tempDirectory = sys_get_temp_dir();

        if (! in_array($tempDirectory, ViewFacade::getFinder()->getPaths())) {
            ViewFacade::addLocation(sys_get_temp_dir());
        }

        $tempFileInfo = pathinfo(tempnam($tempDirectory, 'laravel-blade'));
        $tempFile = $tempFileInfo['dirname'].'/'.$tempFileInfo['filename'].'.blade.php';
        file_put_contents($tempFile, $template);

        if ($this->minLaravelVersion('8.0')) {
            return new \Illuminate\Testing\TestView(view($tempFileInfo['filename'], $data));
        } else {
            return new \Sebastienheyd\Boilerplate\Tests\TestView(view($tempFileInfo['filename'], $data));
        }
    }

    protected function withViewErrors(array $errors, $key = 'default')
    {
        ViewFacade::share('errors', (new ViewErrorBag)->put($key, new MessageBag($errors)));
        return $this;
    }
}