<?php

namespace Sebastienheyd\Boilerplate\Console;

use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Support\Facades\Artisan;

class Dashboard extends BoilerplateCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'boilerplate:dashboard {--r|remove : restore configuration and files to the original state}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate files to build your own boilerplate dashboard';

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

        return $this->option('remove') ? $this->remove() : $this->install();
    }

    private function install()
    {
        $controller = app_path('Http/Controllers/Boilerplate/DashboardController.php');

        if ($this->fileSystem->exists($controller)) {
            $this->error('DashboardController.php already exists in app/Http/Controllers/Boilerplate');

            return self::SUCCESS;
        }

        // Create controller folder
        $controllerPath = app_path('Http/Controllers/Boilerplate');
        $this->fileSystem->makeDirectory($controllerPath, 0755, true, true);

        // Copy and publish files
        $this->copy(__DIR__.'/stubs/DashboardController.stub', $controller);
        $content = $this->fileSystem->get($controller);
        $content = str_replace('Sebastienheyd\Boilerplate\Controllers', 'App\Http\Controllers\Boilerplate', $content);
        $this->fileSystem->put($controller, $content);

        $this->call('vendor:publish', ['--tag' => 'boilerplate-dashboard']);

        // Changes dashboard controller path in configuration file
        $configFile = config_path('boilerplate/menu.php');

        $config = preg_replace(
            "#('dashboard'\s*=>\s*)([^,]*)#",
            '$1\App\Http\Controllers\Boilerplate\DashboardController::class',
            $this->fileSystem->get($configFile)
        );

        $this->fileSystem->put($configFile, $config);
        if (is_file(base_path('bootstrap/cache/routes-v7.php')) || is_file(base_path('bootstrap/cache/routes.php'))) {
            $this->callSilent('route:cache');
        }

        $this->info('Dashboard controller and view has been successfully published!');

        return self::SUCCESS;
    }

    private function remove()
    {
        $path = app_path('Http/Controllers/Boilerplate');
        if (! $this->fileSystem->exists($path.'/DashboardController.php')) {
            $this->info('Custom dashboard is not present, nothing to remove');

            return self::SUCCESS;
        }

        $this->warn('------------------------------------------------------------------------');
        $this->warn(' This command will remove the custom dashboard files and configuration. ');
        $this->warn('------------------------------------------------------------------------');

        if (! $this->confirm('Continue?')) {
            return self::SUCCESS;
        }

        $this->delete($path.'/DashboardController.php');
        if (empty($this->fileSystem->allFiles($path))) {
            $this->fileSystem->deleteDirectory($path);
        }

        $path = resource_path('views/vendor/boilerplate');
        $this->delete($path.'/dashboard.blade.php');
        if (empty($this->fileSystem->allFiles($path))) {
            $this->fileSystem->deleteDirectory($path);
        }

        $configFile = config_path('boilerplate/menu.php');
        $config = preg_replace(
            "#('dashboard'\s*=>\s*)([^,]*)#",
            '$1\Sebastienheyd\Boilerplate\Controllers\DashboardController::class',
            $this->fileSystem->get($configFile)
        );

        $this->fileSystem->put($configFile, $config);

        if (is_file(base_path('bootstrap/cache/routes-v7.php')) || is_file(base_path('bootstrap/cache/routes.php'))) {
            $this->callSilent('route:cache');
        }

        $this->info('Custom dashboard has been removed!');

        return self::SUCCESS;
    }

    /**
     * Copy a file and display a message.
     *
     * @param  string  $from
     * @param  string  $to
     */
    private function copy($from, $to)
    {
        $this->fileSystem->copy($from, $to);
        $from = str_replace(base_path(), '', realpath($from));
        $to = str_replace(base_path(), '', realpath($to));
        $this->line('<info>Copied File</info> <comment>['.$from.']</comment> <info>To</info> <comment>['.$to.']</comment>');
    }

    /**
     * Delete a file and display a message.
     *
     * @param  string  $from
     * @param  string  $to
     */
    private function delete($file)
    {
        $path = str_replace(base_path(), '', realpath($file));
        $this->line('<info>Deleted File</info> <comment>['.$path.']</comment>');
        $this->fileSystem->delete($file);
    }
}
