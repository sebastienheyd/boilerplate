<?php

namespace Sebastienheyd\Boilerplate\Console;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;

class Datatable extends BoilerplateCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'boilerplate:datatable {name? : Name of the datatable to create}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate a new DataTable component';

    protected $fileSystem;

    /**
     * Create a new command instance.
     */
    public function __construct(Filesystem $fileSystem)
    {
        parent::__construct();

        $this->fileSystem = $fileSystem;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->title();

        $name = $this->argument('name');

        if (empty($name)) {
            $name = $this->forceAnswer('Name of the DataTable component to create');
        }

        $camelName = ucfirst(Str::camel(Str::slug($name)));
        $slug = Str::slug($name);

        $content = file_get_contents(__DIR__.'/stubs/Datatable.stub');

        $toReplace = [
            '{{CLASSNAME}}' => $camelName,
            '{{SLUG}}'     => $slug,
        ];

        $content = str_replace(array_keys($toReplace), array_values($toReplace), $content);

        $filePath = app_path('Datatables/'.$camelName.'Datatable.php');

        if (is_file($filePath)) {
            $this->error('Datatable component '.$camelName.' already exists');
            exit;
        }

        if (! is_dir(app_path('Datatables'))) {
            mkdir(app_path('Datatables'), 0775);
        }

        file_put_contents($filePath, $content);
        $this->info('Datatable component generated with success : '.$filePath);
    }
}
