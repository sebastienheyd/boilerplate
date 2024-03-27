<?php

namespace Sebastienheyd\Boilerplate\Console;

use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Support\Str;
use Symfony\Component\Console\Command\Command;

class Widget extends BoilerplateCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'boilerplate:widget {name? : Name of the widget (will be used as slug)}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate a dashboard widget';

    /**
     * Execute the console command.
     *
     * @return mixed
     *
     * @throws FileNotFoundException
     */
    public function handle()
    {
        $this->title();

        $name = $this->argument('name');

        if (empty($name)) {
            $name = $this->forceAnswer('Name of the widget to create (will be used as slug)');
        }

        $slug = Str::slug($name);
        $className = ucfirst(Str::camel(Str::slug($name)));
        $filePath = app_path('Dashboard/'.$className.'.php');

        if (is_file($filePath)) {
            $this->error('Widget '.$slug.' already exists');

            return 1;
        }

        if (! $this->confirm("Generate $slug widget?")) {
            return 0;
        }

        $content = $this->buildStub(__DIR__.'/stubs/DashboardWidget.stub', [
            'CLASS' => $className,
            'SLUG'  => $slug,
        ]);

        $controllerPath = app_path('Dashboard');
        if (! $this->fileSystem->exists($controllerPath)) {
            $this->fileSystem->makeDirectory($controllerPath, 0755, true);
        }

        $this->fileSystem->put($filePath, $content);

        $bladePath = resource_path('views/dashboard/widgets');
        if (! $this->fileSystem->exists($bladePath)) {
            $this->fileSystem->makeDirectory($bladePath, 0755, true);
        }

        $this->fileSystem->copy(__DIR__.'/stubs/widget.blade.php.stub', "$bladePath/$slug.blade.php");
        $this->fileSystem->copy(__DIR__.'/stubs/widgetEdit.blade.php.stub', "$bladePath/$slug".'Edit.blade.php');

        $this->line('<info>Widget generated with success :</info> <comment>'.str_replace(base_path(), '', $filePath).'</comment>');
        $this->line('<info>Widget view added with success :</info> <comment>'.str_replace(base_path(), '', "$bladePath/$slug.blade.php").'</comment>');
        $this->line('<info>Widget settings view added with success :</info> <comment>'.str_replace(base_path(), '', "$bladePath/$slug".'Edit.blade.php').'</comment>');
    }
}
