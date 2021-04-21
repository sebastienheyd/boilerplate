<?php

namespace Sebastienheyd\Boilerplate\Console;

class Dashboard extends BoilerplateCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'boilerplate:dashboard';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate files to build your own boilerplate dashboard';

    /**
     * Create a new command instance.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->title();

        $controller = app_path('Http/Controllers/Boilerplate/DashboardController.php');

        if (file_exists($controller)) {
            $this->error('DashboardController.php already exists in '.app_path('Http/Controllers/Boilerplate'));
            exit;
        }

        // Create controller folder
        $controllerPath = app_path('Http/Controllers/Boilerplate');
        if (!is_dir($controllerPath)) {
            mkdir($controllerPath);
        }

        // Copy and publish files
        copy(__DIR__.'/stubs/DashboardController.stub', $controller);
        $this->callSilent('vendor:publish', ['--tag' => 'boilerplate-dashboard']);

        // Changes dashboard controller path in configuration file
        $configFile = config_path('boilerplate/menu.php');

        if (!is_file($configFile)) {
            $this->callSilent('vendor:publish', ['--tag' => 'boilerplate-config']);
        }

        $config = preg_replace(
            "#('dashboard'\s*=>\s*)([^,]*)#",
            '$1\App\Http\Controllers\Boilerplate\DashboardController::class',
            file_get_contents($configFile)
        );

        if (!file_put_contents($configFile, $config)) {
            $this->error('Error writing to configuration file '.$configFile);
            exit;
        }

        $this->info('Dashboard controller and view has been successfully published !');
        $this->line("You can now edit $controller");
    }
}
