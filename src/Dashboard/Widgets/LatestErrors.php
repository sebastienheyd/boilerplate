<?php

namespace Sebastienheyd\Boilerplate\Dashboard\Widgets;

use Illuminate\Http\Request;
use Sebastienheyd\Boilerplate\Dashboard\Widget;
use Sebastienheyd\Boilerplate\Models\User;

class LatestErrors extends Widget
{
    protected $slug = 'latest-errors';
    protected $label = "Latest errors";
    protected $description = "Shows latest logged errors.";
    protected $size = 'sm';
    protected $view = 'boilerplate::dashboard.widgets.latestErrors';

    public function make()
    {
        $path = str_replace('.log', '', config('logging.channels.daily.path'));

        $files = array_reverse(glob($path.'-*'));

        $errors = [];

        foreach ($files as $file) {
            $handle = fopen($file, "r");
            if ($handle) {
                while (!feof($handle)) {
                    $buffer = fgets($handle, 1024);
                    
                    if(preg_match('#^\[([^\]]+)\]\s([^\.]+)\.ERROR:\s([^\n]+)#', $buffer, $m)) {
                        dd($buffer);
                    }
                }
                fclose($handle);
            }
        }
    }
}