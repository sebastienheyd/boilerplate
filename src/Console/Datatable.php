<?php

namespace Sebastienheyd\Boilerplate\Console;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class Datatable extends BoilerplateCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'boilerplate:datatable {name? : Name of the datatable to create} {--model= : Generate Datatable for the given model}';

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

        $className = ucfirst(Str::camel(Str::slug($name)));
        $slug = Str::slug($name);
        $columns = [];
        $model = '';
        $shortName = '';

        if ($this->hasOption('model')) {
            $model = ltrim($this->option('model'), '\\');
            $shortName = (new \ReflectionClass($this->option('model')))->getShortName();
            $columns = $this->generateColumnsForModel($this->option('model'));
        }

        $content = (string) view(
            'boilerplate::stubs.datatable',
            compact('className', 'slug', 'columns', 'model', 'shortName')
        );

        $filePath = app_path('Datatables/'.$className.'Datatable.php');

        if (is_file($filePath)) {
            $this->error('Datatable component '.$className.' already exists');
            exit;
        }

        if (! is_dir(app_path('Datatables'))) {
            mkdir(app_path('Datatables'), 0775);
        }

        file_put_contents($filePath, $content);
        $this->info('Datatable component generated with success : '.$filePath);
    }

    private function generateColumnsForModel($model)
    {
        $model = new $model();

        $fields = array_merge(
            [$model->getKeyName()],
            array_diff($model->getFillable(), $model->getHidden()),
            $model->timestamps ? ['created_at', 'updated_at'] : []
        );

        $columns = [];

        foreach ($fields as $field) {
            $column = Schema::getConnection()->getDoctrineColumn($model->getTable(), $field);

            $title = Str::of($field)->replace('_', ' ')->title();
            $type = $column->getType()->getName();

            switch ($type) {
                case 'date':
                case 'datetime':
                    $columns[] = (string) view('boilerplate::stubs.columns.date', compact('field', 'title', 'type'));
                    break;

                default:
                    $columns[] = (string) view('boilerplate::stubs.columns.default', compact('field', 'title'));
                    break;
            }
        }

        return $columns;
    }
}
