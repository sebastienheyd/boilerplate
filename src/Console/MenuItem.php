<?php

namespace Sebastienheyd\Boilerplate\Console;

use Illuminate\Support\Str;

class MenuItem extends BoilerplateCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'boilerplate:menuitem {name? : Name of the menu item to add}
                            {--s|submenu : Add sub items to menu item}
                            {--o|order=100 : Order in the backend menu}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add a menu item to the backend menu';

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
            $name = $this->forceAnswer('Name of the menu item to create');
        }

        $camelName = ucfirst(Str::camel(Str::slug($name)));
        $stubFile = $this->option('submenu') ? 'MenuItemSub.stub' : 'MenuItem.stub';
        $filePath = app_path('Menu/'.$camelName.'.php');

        if (is_file($filePath)) {
            $this->error('Menu item '.$camelName.' already exists');

            return 1;
        }

        $content = $this->buildStub(__DIR__.'/stubs/'.$stubFile, [
            'NAME' => $name,
            'ID' => $camelName,
            'ORDER' => intval($this->option('order'))
        ]);

        if (! is_dir(app_path('Menu'))) {
            mkdir(app_path('Menu'), 0775);
        }

        file_put_contents($filePath, $content);
        $this->info('Menu item generated with success : '.$filePath);
    }
}
