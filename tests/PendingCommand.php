<?php

namespace Sebastienheyd\Boilerplate\Tests;

use Illuminate\Foundation\Application as Laravel;

if (version_compare(Laravel::VERSION, '7.0', '>=')) {
    class BasePendingCommand extends \Illuminate\Testing\PendingCommand {}
} else {
    class BasePendingCommand extends \Illuminate\Foundation\Testing\PendingCommand {}
}

class PendingCommand extends BasePendingCommand
{
    public function expectsConfirmation($question, $answer = 'no')
    {
        return $this->expectsQuestion($question, strtolower($answer) === 'yes');
    }

    public function assertSuccessful()
    {
        return $this->assertExitCode(0);
    }

    public function assertFailed()
    {
        return $this->assertExitCode(1);
    }

    public function expectsChoice($question, $answer, $answers, $strict = false)
    {
        $this->test->expectedChoices[$question] = [
            'expected' => $answers,
            'strict' => $strict,
        ];

        return $this->expectsQuestion($question, $answer);
    }
}