<?php

namespace Sebastienheyd\Boilerplate\Console;

use Illuminate\Console\Command;

abstract class BoilerplateCommand extends Command
{
    protected function title()
    {
        $this->info("
  ____        _ _                 _       _
 |  _ \      (_) |               | |     | |
 | |_) | ___  _| | ___ _ __ _ __ | | __ _| |_ ___
 |  _ < / _ \| | |/ _ \ '__| '_ \| |/ _` | __/ _ \
 | |_) | (_) | | |  __/ |  | |_) | | (_| | ||  __/
 |____/ \___/|_|_|\___|_|  | .__/|_|\__,_|\__\___/
                           | |
                           |_|
");
    }

    protected function forceAnswer($question, $default = null)
    {
        if (empty($default)) {
            $default = null;
        }

        $result = $this->ask($question, $default);

        if (! $result) {
            $this->error('Answer cannot be empty');

            return $this->forceAnswer($question, $default);
        }

        return $result;
    }
}
