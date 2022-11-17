<?php

namespace Sebastienheyd\Boilerplate\Tests\Rules;

use Sebastienheyd\Boilerplate\Rules\Password;
use Sebastienheyd\Boilerplate\Tests\TestCase;

class PasswordTest extends TestCase
{
    public function testPasswordRule()
    {
        $rule = new Password(10);

        $this->assertFalse($rule->passes('test', 'a'));
        $this->assertEquals('The :attribute must be at least 10 characters.', $rule->message());

        $this->assertFalse($rule->passes('test', '1234567890'));
        $this->assertEquals('The :attribute must contain at least one letter.', $rule->message());

        $this->assertFalse($rule->passes('test', 'abcdefghif'));
        $this->assertEquals('The :attribute must contain at least one capital letter.', $rule->message());

        $this->assertFalse($rule->passes('test', 'ABCdefghif'));
        $this->assertEquals('The :attribute must contain at least one number.', $rule->message());

        $this->assertFalse($rule->passes('test', 'ABCdefg123'));
        $this->assertEquals('The :attribute must contain at least one special character.', $rule->message());

        $this->assertTrue($rule->passes('test', '*ABCdefg123'));
    }
}