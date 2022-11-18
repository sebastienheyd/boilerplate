<?php

namespace Sebastienheyd\Boilerplate\Tests;

class PendingCommand extends \Illuminate\Foundation\Testing\PendingCommand
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