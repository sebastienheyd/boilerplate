<?php

namespace Sebastienheyd\Boilerplate\Console\Commands;

use Illuminate\Console\Command;

class MenuItem extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'boilerplate:menuitem {name} 
                            {--s|submenu : Add sub items to menu item} 
                            {--o|order=100 : Order in the backend menu}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add a menu item to the backend menu';

    /**
     * Create a new command instance.
     *
     * @return void
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
        $name = ucfirst(camel_case($this->argument('name')));
        $order = intval($this->option('order'));
        $stubFile = $this->option('submenu') ? 'MenuItemSub.stub' : 'MenuItem.stub';

        $stub = file_get_contents(__DIR__.'/stubs/'.$stubFile);

        $content = preg_replace('#{{NAME}}#', $name, $stub);
        $content = preg_replace('#{{ID}}#', mb_strtolower($name), $content);
        $content = preg_replace('#{{ORDER}}#', $order, $content);
        $content = preg_replace('#{{ORDER\+1}}#', $order + 1, $content);
        $content = preg_replace('#{{ORDER\+2}}#', $order + 2, $content);

        if(!is_dir(app_path('Menu'))) {
            mkdir(app_path('Menu'), 0775);
        }

        if(is_file(app_path('Menu/'.$name.'.php'))) {
            $this->error('Menu item '.$name.' already exists');
            exit;
        }

        file_put_contents(app_path('Menu/'.$name.'.php'), $content);
        $this->info('Menu item generated with success : app/Menu/'.$name.'.php');
    }
}
