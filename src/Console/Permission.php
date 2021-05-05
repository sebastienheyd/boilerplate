<?php

namespace Sebastienheyd\Boilerplate\Console;

use Illuminate\Support\Str;
use Sebastienheyd\Boilerplate\Models\PermissionCategory;

class Permission extends BoilerplateCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'boilerplate:permission';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a migration file to add a new permission';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->title();

        $name = $this->forceAnswer('Name of the permission to create (snake_case)');
        $displayName = $this->forceAnswer('Full name of the permission (can be a locale string)');
        $description = $this->forceAnswer('Full description of the permission (can be a locale string)');
        $categoryName = '';
        $categoryDescription = '';

        if ($this->confirm('Create or assign to a permissions group?')) {
            $categories = PermissionCategory::pluck('name')->toArray();
            $categoryName = (string) $this->choice('Permissions groups', array_merge([
                'Create a new group',
            ], $categories));

            if ($categoryName === 'Create a new group') {
                $categoryName = $this->forceAnswer('Name of the group (snake_case)');
                $categoryName = Str::slug($categoryName, '_');
                $categoryDescription = $this->forceAnswer('Full name of the group (can be a locale string)');
            }
        }

        $name = Str::slug($name, '_');
        $className = 'Add'.ucfirst(Str::camel($name)).'Permission';
        $fileName = date('Y_m_d_His').'_add_'.$name.'_permission.php';
        $stub = 'Permission';

        if (! empty($categoryName)) {
            $stub = 'PermissionCat';

            if (! empty($categoryDescription)) {
                $className = 'Add'.ucfirst(Str::camel($categoryName)).'Permissions';
                $fileName = date('Y_m_d_His').'_add_'.$categoryName.'_permissions.php';
                $stub = 'PermissionNewCat';
            }
        }

        $stub = __DIR__.DIRECTORY_SEPARATOR.'stubs'.DIRECTORY_SEPARATOR.$stub.'.stub';
        $content = file_get_contents($stub);

        $toReplace = [
            'PERMISSION_CLASS' => $className,
            'PERMISSION_NAME' => $name,
            'PERMISSION_DISPLAY_NAME' => $displayName,
            'PERMISSION_DESC' => $description,
            'CATEGORY_NAME' => $categoryName,
            'CATEGORY_DESC' => $categoryDescription,
        ];

        $toReplace = array_map(function ($str) {
            return str_replace("'", "\'", $str);
        }, $toReplace);

        $content = str_replace(array_keys($toReplace), array_values($toReplace), $content);
        $path = base_path('database'.DIRECTORY_SEPARATOR.'migrations'.DIRECTORY_SEPARATOR.$fileName);
        file_put_contents($path, $content);

        $this->info('Migration has been created : '.$path);
    }
}
