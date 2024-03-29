<?php

namespace Sebastienheyd\Boilerplate\Console;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

abstract class BoilerplateCommand extends Command
{
    /**
     * Instance of current Filesystem.
     *
     * @var Filesystem
     */
    protected $fileSystem;

    public function __construct(Filesystem $fileSystem)
    {
        parent::__construct();
        $this->fileSystem = $fileSystem;
    }

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
        $result = $this->ask($question, $default);

        if (empty($result)) {
            $this->error('Answer cannot be empty');

            return $this->forceAnswer($question, $default);
        }

        return $result;
    }

    protected function buildStub($stubFile, $replacements = [])
    {
        $content = file_get_contents($stubFile);

        foreach ($replacements as $key => $value) {
            $content = str_replace('{{'.$key.'}}', $value, $content);
        }

        return $content;
    }
}
