<?php

namespace Sebastienheyd\Boilerplate\Console;

use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Str;
use ReflectionException;

class Datatable extends BoilerplateCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'boilerplate:datatable 
        {name? : Name of the datatable to create} 
        {--model= : Generate Datatable for the given model}
        {--nodb : Generate without using the database to get types}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate a new DataTable component';

    /**
     * Execute the console command.
     *
     * @return mixed
     *
     * @throws ReflectionException
     */
    public function handle()
    {
        $this->title();

        $name = $this->argument('name');

        if (empty($name)) {
            $name = $this->forceAnswer('Name of the DataTable component to create (E.g., <comment>users</comment>)');
        }

        $className = ucfirst(Str::camel(Str::slug($name)));
        $slug = Str::slug($name);
        $columns = [];
        $model = '';
        $shortName = '';

        if ($this->option('model') === null) {
            if ($this->confirm('Use a model as the data source?')) {
                model:
                $model = $this->forceAnswer('Enter the model to use (E.g., <comment>App\Models\User</comment>)');
                $this->input->setOption('model', $model);
            }
        }

        if ($this->option('model')) {
            $model = ltrim($this->option('model'), '\\');

            if (! class_exists($model)) {
                $this->error("Class $model does not exists");
                goto model;
            }

            $shortName = (new \ReflectionClass($this->option('model')))->getShortName();

            try {
                $columns = $this->generateColumnsForModel($this->option('model'));
            } catch (Exception $exception) {
                $this->error('Model structure is not accessible in the database');

                return 1;
            }
        }

        $content = (string) view(
            'boilerplate::stubs.datatable',
            compact('className', 'slug', 'columns', 'model', 'shortName')
        );

        $filePath = app_path('Datatables/'.$className.'Datatable.php');

        if (is_file($filePath)) {
            if (! $this->confirm("File <comment>$filePath</comment> already exists, overwrite?")) {
                return 0;
            }

            unlink($filePath);
        }

        if (! is_dir(app_path('Datatables'))) {
            mkdir(app_path('Datatables'), 0775);
        }

        file_put_contents($filePath, $content);
        $this->line('<info>Datatable component generated with success :</info> <comment>'.$filePath.'</comment>');
        $this->line('<info>Now you can use the component with the tag : </info> <comment><x-boilerplate::datatable name="'.$slug.'" /></comment>');
    }

    private function generateColumnsForModel($model)
    {
        $model = new $model();

        $fields = array_merge(
            [$model->getKeyName()],
            array_diff($model->getFillable(), $model->getHidden()),
            $model->timestamps ? ['created_at', 'updated_at'] : []
        );

        $fields = array_unique($fields);

        $columns = [];
        $connection = $model->getConnection();

        foreach ($fields as $field) {
            if (! $this->option('nodb')) {
                $type = $connection->getSchemaBuilder()->getColumnType($model->getTable(), $field);
            } else {
                $type = preg_match('#_at$#', $field) ? 'datetime' : 'default';
            }

            $title = Str::title(str_replace('_', ' ', $field));

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
